package main

import (
	"fmt"
)

func getLength(s string, c chan int) {
	c <- len(s)
}

func main() {
	var str1, str2 string

	str1 = "makpal"
	str2 = "adam"

	c := make(chan int)

	go getLength(str1, c)
	go getLength(str2, c)

	len1, len2 := <-c, <-c

	fmt.Printf("%d and %d\n", len1, len2)
	fmt.Printf("%d\n", len1+len2)
}
