# Stage 1: Build Frontend Assets (Repeated to ensure independent Nginx image)
FROM node:20 as frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Nginx
FROM nginx:alpine

# Copy configuration
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy public directory (including index.php and built assets)
# Note: Nginx needs index.php to rely on try_files checks, and importantly css/js in build/
COPY --from=frontend /app/public /var/www/public
