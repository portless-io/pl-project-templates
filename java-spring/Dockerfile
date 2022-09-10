FROM openjdk:17

ENV API_KEY=your-project-apiKey
COPY target/*.jar app.jar
ENTRYPOINT ["java","-jar","/app.jar"]
