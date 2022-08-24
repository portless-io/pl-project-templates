package main

import (
	"encoding/json"
	"net/http"

	"github.com/labstack/echo/v4"
	microgen "github.com/mejik-dev/microgen-v3-go"
)

func main() {
	e := echo.New()
	client := microgen.NewClient("1dbc2a74-60c6-4f64-92bc-b311a26164df", microgen.DefaultURL())

	e.GET("", func(c echo.Context) error {
		return c.String(http.StatusOK, "hello world")
	})

	products := e.Group("/products")
	products.GET("", func(c echo.Context) error {
		resp, err := client.Service("products").Find()
		if err != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.POST("", func(c echo.Context) error {
		body := make(map[string]interface{})
		err := json.NewDecoder(c.Request().Body).Decode(&body)
		if err != nil {
			return c.String(http.StatusBadRequest, "failed parse request body to json")
		}

		resp, errr := client.Service("products").Create(body)
		if errr != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.PATCH("/:id", func(c echo.Context) error {
		id := c.Param("id")
		body := make(map[string]interface{})

		err := json.NewDecoder(c.Request().Body).Decode(&body)
		if err != nil {
			return c.String(http.StatusBadRequest, "failed parse request body to json")
		}

		resp, errr := client.Service("products").UpdateByID(id, body)
		if errr != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.DELETE("/:id", func(c echo.Context) error {
		id := c.Param("id")
		resp, err := client.Service("products").DeleteByID(id)
		if err != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	products.GET("/:id", func(c echo.Context) error {
		id := c.Param("id")
		res, err := client.Service("products").GetByID(id)
		if err != nil {
			return c.JSON(http.StatusInternalServerError, err)
		}

		return c.JSON(http.StatusOK, res.Data)
	})

	e.Logger.Fatal(e.Start(":3000"))
}
