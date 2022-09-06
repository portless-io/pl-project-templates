package main

import (
	"encoding/json"
	"net/http"
	"os"

	"github.com/labstack/echo/v4"
	"github.com/labstack/echo/v4/middleware"
	microgen "github.com/mejik-dev/microgen-v3-go"
)

var API_KEY = os.Getenv("API_KEY")

func main() {
	e := echo.New()
	e.Pre(middleware.RemoveTrailingSlash())

	client := microgen.NewClient(API_KEY, microgen.DefaultURL())

	e.GET("", func(c echo.Context) error {
		return c.String(http.StatusOK, "hello world")
	})

	products := e.Group("/products")
	products.GET("", func(c echo.Context) error {
		resp, err := client.Service("products").Find()
		if err != nil {
			if err.Message == "project not found" {
				return c.JSON(err.Status, map[string]interface{}{
					"message": "please check your project or api key.",
				})
			}

			return c.JSON(err.Status, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.POST("", func(c echo.Context) error {
		body := make(map[string]interface{})

		if err := json.NewDecoder(c.Request().Body).Decode(&body); err != nil {
			return c.String(http.StatusBadRequest, "failed parse request body to json")
		}

		resp, err := client.Service("products").Create(body)
		if err != nil {
			if err.Message == "project not found" {
				return c.JSON(err.Status, map[string]interface{}{
					"message": "please check your project or api key.",
				})
			}

			return c.JSON(err.Status, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.PATCH("/:id", func(c echo.Context) error {
		id := c.Param("id")
		body := make(map[string]interface{})

		if err := json.NewDecoder(c.Request().Body).Decode(&body); err != nil {
			return c.String(http.StatusBadRequest, "failed parse request body to json")
		}

		resp, err := client.Service("products").UpdateByID(id, body)
		if err != nil {
			if err.Message == "project not found" {
				return c.JSON(err.Status, map[string]interface{}{
					"message": "please check your project or api key.",
				})
			}

			return c.JSON(err.Status, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.DELETE("/:id", func(c echo.Context) error {
		id := c.Param("id")
		resp, err := client.Service("products").DeleteByID(id)
		if err != nil {
			if err.Message == "project not found" {
				return c.JSON(err.Status, map[string]interface{}{
					"message": "please check your project or api key.",
				})
			}

			return c.JSON(err.Status, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.GET("/:id", func(c echo.Context) error {
		id := c.Param("id")
		res, err := client.Service("products").GetByID(id)
		if err != nil {
			if err.Message == "project not found" {
				return c.JSON(err.Status, map[string]interface{}{
					"message": "please check your project or api key.",
				})
			}

			return c.JSON(err.Status, err)
		}

		return c.JSON(http.StatusOK, res.Data)
	})

	e.Logger.Fatal(e.Start(":3000"))
}
