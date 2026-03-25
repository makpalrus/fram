package handlers

import (
	"awesomeProject/models"
	"github.com/gin-gonic/gin"
	"net/http"
)

var categories []models.Category

// GET /categories
func GetCategories(c *gin.Context) {
	c.JSON(http.StatusOK, categories)
}

// POST /categories
func CreateCategory(c *gin.Context) {
	var cat models.Category
	if err := c.ShouldBindJSON(&cat); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	if cat.Name == "" {
		c.JSON(http.StatusBadRequest, gin.H{"error": "name is required"})
		return
	}
	cat.ID = len(categories) + 1
	categories = append(categories, cat)
	c.JSON(http.StatusCreated, cat)
}
