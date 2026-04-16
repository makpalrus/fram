package models

import "time"

type FavoriteBook struct {
	UserID    uint      `gorm:"primaryKey;autoCreateTime:false" json:"user_id"`
	BookID    uint      `gorm:"primaryKey;autoCreateTime:false" json:"book_id"`
	CreatedAt time.Time `gorm:"autoCreateTime" json:"created_at"`
}
