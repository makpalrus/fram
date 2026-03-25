package handlers

import (
	"awesomeProject/models"
	"github.com/gin-gonic/gin"
	"net/http"
)

var authors []models.Author

func GetAuthors(c *gin.Context) {
	c.JSON(http.StatusOK, authors)
}

func CreateAuthor(c *gin.Context) {
	var a models.Author
	if err := c.ShouldBindJSON(&a); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	if a.Name == "" {
		c.JSON(http.StatusBadRequest, gin.H{"error": "name is required"})
		return
	}
	a.ID = len(authors) + 1
	authors = append(authors, a)
	c.JSON(http.StatusCreated, a)
}
