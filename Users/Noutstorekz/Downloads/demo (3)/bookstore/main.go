package main

import (
	"bookstore/db"
	"bookstore/handlers"
	"bookstore/middleware"
	"bookstore/models"
	"log"

	"github.com/gin-gonic/gin"
)

func main() {
	db.ConnectDatabase()

	if err := db.DB.AutoMigrate(
		&models.User{},
		&models.Author{},
		&models.Category{},
		&models.Book{},
		&models.FavoriteBook{},
	); err != nil {
		log.Fatal("Migration failed:", err)
	}

	r := gin.Default()

	r.POST("/register", handlers.Register)
	r.POST("/login", handlers.Login)

	r.GET("/authors", handlers.GetAuthors)
	r.POST("/authors", handlers.CreateAuthor)

	r.GET("/categories", handlers.GetCategories)
	r.POST("/categories", handlers.CreateCategory)

	r.GET("/books", handlers.GetBooks)
	r.GET("/books/:id", handlers.GetBook)
	r.POST("/books", handlers.CreateBook)
	r.PUT("/books/:id", handlers.UpdateBook)
	r.DELETE("/books/:id", handlers.DeleteBook)

	r.GET("/users", handlers.GetUsers)
	r.GET("/users/:id", handlers.GetUser)
	r.POST("/users", handlers.CreateUser)
	r.PUT("/users/:id", handlers.UpdateUser)
	r.DELETE("/users/:id", handlers.DeleteUser)

	protected := r.Group("/books")
	protected.Use(middleware.AuthMiddleware())
	{
		protected.GET("/favorites", handlers.GetFavorites)
		protected.PUT("/:id/favorites", handlers.AddToFavorites)
		protected.DELETE("/:id/favorites", handlers.RemoveFromFavorites)
	}

	r.Run(":8080")
}
