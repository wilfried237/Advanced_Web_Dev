# frontend/Dockerfile
FROM nginx:latest

# Copy frontend files to the container
COPY ./src /usr/share/nginx/html

# Expose port 80
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
