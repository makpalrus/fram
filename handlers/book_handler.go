package handlers

import (
	"awesomeProject/models"
	"github.com/gin-gonic/gin"
	"net/http"
	"strconv"
)

var books []models.Book

// findBook returns the index of a book by ID, or -1 if not found.
func findBook(id int) int {
	for i, b := range books {
		if b.ID == id {
			return i
		}
	}
	return -1
}

// GET /books?category=Fiction&page=1&limit=5
func GetBooks(c *gin.Context) {
	// --- filter by category name ---
	categoryFilter := c.Query("category")

	// --- pagination params (defaults: page=1, limit=10) ---
	page, err := strconv.Atoi(c.DefaultQuery("page", "1"))
	if err != nil || page < 1 {
		page = 1
	}
	limit, err := strconv.Atoi(c.DefaultQuery("limit", "10"))
	if err != nil || limit < 1 {
		limit = 10
	}

	// --- apply category filter ---
	var filtered []models.Book
	for _, b := range books {
		if categoryFilter == "" {
			filtered = append(filtered, b)
			continue
		}
		for _, cat := range categories {
			if cat.ID == b.CategoryID && cat.Name == categoryFilter {
				filtered = append(filtered, b)
			}
		}
	}

	// --- paginate ---
	total := len(filtered)
	start := (page - 1) * limit
	if start >= total {
		c.JSON(http.StatusOK, gin.H{
			"page": page, "limit": limit,
			"total": total, "books": []models.Book{},
		})
		return
	}
	end := start + limit
	if end > total {
		end = total
	}
	c.JSON(http.StatusOK, gin.H{
		"page":  page,
		"limit": limit,
		"total": total,
		"books": filtered[start:end],
	})
}

// POST /books
func CreateBook(c *gin.Context) {
	var b models.Book
	if err := c.ShouldBindJSON(&b); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	// Validation
	if b.Title == "" {
		c.JSON(http.StatusBadRequest, gin.H{"error": "title is required"})
		return
	}
	if b.Price <= 0 {
		c.JSON(http.StatusBadRequest, gin.H{"error": "price must be greater than 0"})
		return
	}
	b.ID = len(books) + 1
	books = append(books, b)
	c.JSON(http.StatusCreated, b)
}

// GET /books/:id
func GetBook(c *gin.Context) {
	id, err := strconv.Atoi(c.Param("id"))
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "invalid id"})
		return
	}
	idx := findBook(id)
	if idx == -1 {
		c.JSON(http.StatusNotFound, gin.H{"error": "book not found"})
		return
	}
	c.JSON(http.StatusOK, books[idx])
}

// PUT /books/:id
func UpdateBook(c *gin.Context) {
	id, err := strconv.Atoi(c.Param("id"))
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "invalid id"})
		return
	}
	idx := findBook(id)
	if idx == -1 {
		c.JSON(http.StatusNotFound, gin.H{"error": "book not found"})
		return
	}
	var updated models.Book
	if err := c.ShouldBindJSON(&updated); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	if updated.Title == "" {
		c.JSON(http.StatusBadRequest, gin.H{"error": "title is required"})
		return
	}
	if updated.Price <= 0 {
		c.JSON(http.StatusBadRequest, gin.H{"error": "price must be greater than 0"})
		return
	}
	updated.ID = id
	books[idx] = updated
	c.JSON(http.StatusOK, updated)
}

// DELETE /books/:id
func DeleteBook(c *gin.Context) {
	id, err := strconv.Atoi(c.Param("id"))
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "invalid id"})
		return
	}
	idx := findBook(id)
	if idx == -1 {
		c.JSON(http.StatusNotFound, gin.H{"error": "book not found"})
		return
	}
	// Remove element preserving order
	books = append(books[:idx], books[idx+1:]...)
	c.JSON(http.StatusNoContent, nil)
}
