package com.example.demo;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.util.HashMap;

import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.core.env.Environment;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;


@SpringBootApplication
@RestController
public class Application implements CommandLineRunner {
  private final String BASE_URL = "https://api.stagingv3.microgen.id/query/api/v1";
  protected String PRODUCT_SERVICE_URL = BASE_URL + "/products";

  private final Environment env;

  public Application(Environment env) {
      this.env = env;
  }

  @Override
  public void run(String... args) throws Exception {
      String apiKey = env.getProperty("API_KEY");

      if(apiKey == null || apiKey.isEmpty()) {
        System.out.println("api key is required.");
      }

      this.PRODUCT_SERVICE_URL = this.BASE_URL + "/" + apiKey + "/products";
  }

  public static void main(String[] args) {
      SpringApplication.run(Application.class, args);
  }

  @RequestMapping("/")
  public String home() {
    return "Hello World";
  }

  @GetMapping("/products")
  public ResponseEntity<String> getProducts() {
    try {
      HttpClient client = HttpClient.newHttpClient();
      HttpRequest request = HttpRequest.newBuilder()
              .uri(URI.create(this.PRODUCT_SERVICE_URL))
              .build();

      HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());

      String body = response.body();
      ObjectMapper mapper = new ObjectMapper();
      JsonNode rootNode = mapper.readTree(body);

      if (response.statusCode() != 200) {
        if (rootNode.get("message").asText().contains("project not found")) {
          var respObj = new HashMap<String, String>() {{
              put("message", "failed to connect to your project, please check if the api had been set properly.");
          }};

          return ResponseEntity.status(response.statusCode()).body(mapper.writeValueAsString(respObj));
        }

        return ResponseEntity.status(response.statusCode()).body(body);
      }

      return ResponseEntity.status(response.statusCode()).body(body);
    } catch (Exception e) {
      // TODO: handle exception
      return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("internal server error");
    }
  }

  @PostMapping(path = "/products", consumes = "application/json")
  public ResponseEntity<String> updateProduct(@RequestBody Object product) {
    ObjectMapper mapper = new ObjectMapper();

    try {
      HttpClient client = HttpClient.newHttpClient();
      HttpRequest request = HttpRequest.newBuilder()
              .uri(URI.create(this.PRODUCT_SERVICE_URL))
              .POST(HttpRequest.BodyPublishers.ofString(mapper.writeValueAsString(product)))
              .header("Content-Type", "application/json")
              .build();

      HttpResponse<String> response = client.send(request,HttpResponse.BodyHandlers.ofString());

      String body = response.body();
      JsonNode rootNode = mapper.readTree(body);
      
      if (response.statusCode() != 201) {
        if (rootNode.get("message").asText().contains("project not found")) {
          var respObj = new HashMap<String, String>() {{
              put("message", "failed to connect to your project, please check if the api had been set properly.");
          }};

          return ResponseEntity.status(response.statusCode()).body(mapper.writeValueAsString(respObj));
        }

        return ResponseEntity.status(response.statusCode()).body(body);
      }

      return ResponseEntity.status(response.statusCode()).body(body);
    } catch (Exception e) {
      // TODO: handle exception
      return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("internal server error");
    }
  }

  @GetMapping("/products/{id}")
  public ResponseEntity<String> getProduct(@PathVariable String id) {
    try {
      HttpClient client = HttpClient.newHttpClient();
      HttpRequest request = HttpRequest.newBuilder()
              .uri(URI.create(this.PRODUCT_SERVICE_URL + "/" + id))
              .build();

      HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());

      String body = response.body();
      ObjectMapper mapper = new ObjectMapper();
      JsonNode rootNode = mapper.readTree(body);

      if (response.statusCode() != 200) {
        if (rootNode.get("message").asText().contains("project not found")) {
          var respObj = new HashMap<String, String>() {{
              put("message", "failed to connect to your project, please check if the api had been set properly.");
          }};

          return ResponseEntity.status(response.statusCode()).body(mapper.writeValueAsString(respObj));
        }

        return ResponseEntity.status(response.statusCode()).body(body);
      }

      return ResponseEntity.status(response.statusCode()).body(body);
    } catch (Exception e) {
      // TODO: handle exception
      return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("internal server error");
    }
  }

  @PatchMapping(path = "/products/{id}", consumes = "application/json")
  public ResponseEntity<String> createProduct(@PathVariable String id, @RequestBody Object reqObject) {
    ObjectMapper mapper = new ObjectMapper();

    try {
      HttpClient client = HttpClient.newHttpClient();
      HttpRequest request = HttpRequest.newBuilder()
              .uri(URI.create(this.PRODUCT_SERVICE_URL + "/" + id))
              .method("PATCH", HttpRequest.BodyPublishers.ofString(mapper.writeValueAsString(reqObject)))
              .header("Content-Type", "application/json")
              .build();

      HttpResponse<String> response = client.send(request,HttpResponse.BodyHandlers.ofString());

      String body = response.body();
      JsonNode rootNode = mapper.readTree(body);
      
      if (response.statusCode() != 201) {
        if (rootNode.get("message").asText().contains("project not found")) {
          var respObj = new HashMap<String, String>() {{
              put("message", "failed to connect to your project, please check if the api had been set properly.");
          }};

          return ResponseEntity.status(response.statusCode()).body(mapper.writeValueAsString(respObj));
        }

        return ResponseEntity.status(response.statusCode()).body(body);
      }

      return ResponseEntity.status(response.statusCode()).body(body);
    } catch (Exception e) {
      // TODO: handle exception
      return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("internal server error");
    }
  }

@DeleteMapping("/products/{id}")
  public ResponseEntity<String> deleteProduct(@PathVariable String id) {
    try {
      HttpClient client = HttpClient.newHttpClient();
      HttpRequest request = HttpRequest.newBuilder()
              .uri(URI.create(this.PRODUCT_SERVICE_URL + "/" + id))
              .DELETE()
              .build();

      HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());

      String body = response.body();
      ObjectMapper mapper = new ObjectMapper();
      JsonNode rootNode = mapper.readTree(body);

      if (response.statusCode() != 200) {
        if (rootNode.get("message").asText().contains("project not found")) {
          var respObj = new HashMap<String, String>() {{
              put("message", "failed to connect to your project, please check if the api had been set properly.");
          }};

          return ResponseEntity.status(response.statusCode()).body(mapper.writeValueAsString(respObj));
        }

        return ResponseEntity.status(response.statusCode()).body(body);
      }

      return ResponseEntity.status(response.statusCode()).body(body);
    } catch (Exception e) {
      // TODO: handle exception
      return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("internal server error");
    }
  }
}
