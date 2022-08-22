package main

import (
	"encoding/json"
	"net/http"

	"github.com/labstack/echo/v4"
	microgen "github.com/mejik-dev/microgen-v3-go"
)

func main() {
	e := echo.New()
	client := microgen.NewClient("033506d6-9742-4298-855a-fb19974b6c75", microgen.DefaultURL())

	songsRoutes := e.Group("/songs")

	songsRoutes.GET("", func(c echo.Context) error {
		resp, err := client.Service("songs").Find()
		if err != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	songsRoutes.POST("", func(c echo.Context) error {
		body := make(map[string]interface{})
		err := json.NewDecoder(c.Request().Body).Decode(&body)
		if err != nil {
			return c.String(http.StatusBadRequest, "failed parse request body to json")
		}

		resp, errr := client.Service("songs").Create(body)
		if errr != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	songsRoutes.PATCH("/:id", func(c echo.Context) error {
		id := c.Param("id")
		body := make(map[string]interface{})

		err := json.NewDecoder(c.Request().Body).Decode(&body)
		if err != nil {
			return c.String(http.StatusBadRequest, "failed parse request body to json")
		}

		resp, errr := client.Service("songs").UpdateByID(id, body)
		if errr != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	songsRoutes.DELETE("/:id", func(c echo.Context) error {
		id := c.Param("id")
		resp, err := client.Service("songs").DeleteByID(id)
		if err != nil {
			return c.JSON(http.StatusNonAuthoritativeInfo, err)
		}

		return c.JSON(http.StatusOK, resp.Data)
	})

	songsRoutes.GET("/:id", func(c echo.Context) error {
		id := c.Param("id")
		res, err := client.Service("songs").GetByID(id)
		if err != nil {
			return c.JSON(http.StatusInternalServerError, err)
		}

		return c.JSON(http.StatusOK, res.Data)
	})

	e.Logger.Fatal(e.Start(":3000"))
}
