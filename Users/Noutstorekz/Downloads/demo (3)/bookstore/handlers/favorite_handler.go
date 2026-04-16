package handlers

import (
	"bookstore/db"
	"bookstore/models"
	"errors"
	"net/http"
	"strconv"

	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

func getUserID(c *gin.Context) (uint, bool) {
	raw, exists := c.Get("user_id")
	if !exists {
		return 0, false
	}
	switch v := raw.(type) {
	case float64:
		return uint(v), true
	case uint:
		return v, true
	default:
		return 0, false
	}
}

func GetFavorites(c *gin.Context) {
	userID, ok := getUserID(c)
	if !ok {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "Unauthorized"})
		return
	}

	page, _ := strconv.Atoi(c.DefaultQuery("page", "1"))
	limit, _ := strconv.Atoi(c.DefaultQuery("limit", "5"))
	if page < 1 {
		page = 1
	}
	if limit < 1 || limit > 100 {
		limit = 5
	}
	offset := (page - 1) * limit

	var total int64
	db.DB.Model(&models.FavoriteBook{}).
		Where("user_id = ?", userID).
		Count(&total)

	var favoriteBooks []models.Book
	db.DB.Table("books").
		Joins("JOIN favorite_books ON favorite_books.book_id = books.id").
		Where("favorite_books.user_id = ?", userID).
		Order("favorite_books.created_at DESC").
		Limit(limit).
		Offset(offset).
		Find(&favoriteBooks)

	c.JSON(http.StatusOK, gin.H{
		"data":  favoriteBooks,
		"total": total,
		"page":  page,
		"limit": limit,
	})
}

func AddToFavorites(c *gin.Context) {
	userID, ok := getUserID(c)
	if !ok {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "Unauthorized"})
		return
	}

	bookID, err := strconv.Atoi(c.Param("id"))
	if err != nil || bookID < 1 {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid book ID"})
		return
	}

	var book models.Book
	if err := db.DB.First(&book, bookID).Error; err != nil {
		if errors.Is(err, gorm.ErrRecordNotFound) {
			c.JSON(http.StatusNotFound, gin.H{"error": "Book not found"})
		} else {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Database error"})
		}
		return
	}

	var existing models.FavoriteBook
	err = db.DB.Where("user_id = ? AND book_id = ?", userID, bookID).First(&existing).Error
	if err == nil {
		c.JSON(http.StatusConflict, gin.H{"error": "Book is already in favorites"})
		return
	}
	if !errors.Is(err, gorm.ErrRecordNotFound) {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Database error"})
		return
	}

	fav := models.FavoriteBook{
		UserID: userID,
		BookID: uint(bookID),
	}
	if err := db.DB.Create(&fav).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Could not add to favorites"})
		return
	}

	c.JSON(http.StatusOK, gin.H{"message": "Added to favorites"})
}

func RemoveFromFavorites(c *gin.Context) {
	userID, ok := getUserID(c)
	if !ok {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "Unauthorized"})
		return
	}

	bookID, err := strconv.Atoi(c.Param("id"))
	if err != nil || bookID < 1 {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid book ID"})
		return
	}

	result := db.DB.
		Where("user_id = ? AND book_id = ?", userID, bookID).
		Delete(&models.FavoriteBook{})

	if result.Error != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Could not remove from favorites"})
		return
	}
	if result.RowsAffected == 0 {
		c.JSON(http.StatusNotFound, gin.H{"error": "Favorite not found"})
		return
	}

	c.JSON(http.StatusOK, gin.H{"message": "Removed from favorites"})
}
