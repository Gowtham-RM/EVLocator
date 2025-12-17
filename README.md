# EV Charging Station Locator

A web application to locate and manage EV charging stations.

## Features
- Interactive map to locate charging stations
- Add new charging stations
- View station details
- User authentication and admin panel

## Technologies
- **Backend**: Node.js, Express
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript

## Deployment

### Render Deployment Steps:

1. **Create a Render Account**: Go to [render.com](https://render.com) and sign up

2. **Create a MySQL Database**:
   - Click "New +" and select "PostgreSQL" (or use an external MySQL service like PlanetScale)
   - Note: Render's free tier includes PostgreSQL. For MySQL, consider using:
     - [PlanetScale](https://planetscale.com) (free tier)
     - [Railway](https://railway.app) (MySQL support)

3. **Deploy Web Service**:
   - Click "New +" → "Web Service"
   - Connect your GitHub repository
   - Configure:
     - **Name**: evlocator-backend
     - **Runtime**: Node
     - **Build Command**: `npm install`
     - **Start Command**: `node server.js`
   
4. **Set Environment Variables** in Render Dashboard:
   ```
   DB_HOST=your-database-host
   DB_USER=your-database-user
   DB_PASSWORD=your-database-password
   DB_NAME=charging_stations_db
   DB_PORT=3306
   ```

5. **Database Setup**:
   Create the required table in your MySQL database:
   ```sql
   CREATE TABLE charging_stations (
     id INT AUTO_INCREMENT PRIMARY KEY,
     latitude DECIMAL(10, 8) NOT NULL,
     longitude DECIMAL(11, 8) NOT NULL,
     name VARCHAR(255) NOT NULL,
     address TEXT,
     image_url TEXT
   );
   ```

## Local Development

1. Install dependencies:
   ```bash
   npm install
   ```

2. Create a `.env` file (use `.env.example` as template)

3. Start the server:
   ```bash
   npm start
   ```

4. Access at `http://localhost:3000`

## License
ISC
