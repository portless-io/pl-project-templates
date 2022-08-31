FROM golang:1.18.5-alpine
WORKDIR /app
COPY . .
RUN go mod tidy
RUN go build -o /entry_point server.go
CMD ["/entry_point"]
