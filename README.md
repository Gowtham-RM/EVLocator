# EV Charging Station Locator

A web application to locate and manage EV charging stations.

## Features
- Interactive map to locate charging stations
- Add new charging stations
- View station details
- User authentication and admin panel

## Technologies
- **Backend**: Node.js, Express
- **Database**: PostgreSQL
- **Frontend**: HTML, CSS, JavaScript

## Free Deployment on Render

### Step 1: Create PostgreSQL Database on Render

1. Go to [render.com](https://render.com) and sign up
2. Click **"New +"** → **"PostgreSQL"**
3. Configure:
   - **Name**: evlocator-db
   - **Database**: evlocator
   - **User**: (auto-generated)
   - **Region**: Choose closest to you
   - **Instance Type**: **Free**
4. Click **"Create Database"**
5. Wait for database to be created (~2 minutes)
6. Copy the **Internal Database URL** (starts with `postgres://`)

### Step 2: Create Database Table

1. In your Render database dashboard, click **"Connect"** → **"External Connection"**
2. Use the PSQL Command or any PostgreSQL client
3. Run this SQL:

```sql
CREATE TABLE charging_stations (
  id SERIAL PRIMARY KEY,
  latitude DECIMAL(10, 8) NOT NULL,
  longitude DECIMAL(11, 8) NOT NULL,
  name VARCHAR(255) NOT NULL,
  address TEXT,
  image_url TEXT
);
```

### Step 3: Deploy Web Service

1. In Render, click **"New +"** → **"Web Service"**
2. Connect your GitHub repository: **Gowtham-RM/EVLocator**
3. Configure:
   - **Name**: evlocator
   - **Region**: Same as database
   - **Branch**: main
   - **Runtime**: Node
   - **Build Command**: `npm install`
   - **Start Command**: `node server.js`
   - **Instance Type**: **Free**

4. **Add Environment Variables**:
   - Click **"Advanced"** or scroll to **"Environment Variables"**
   - Instead of adding individual variables, use **DATABASE_URL**:
     - Key: `DATABASE_URL`
     - Value: Paste the **Internal Database URL** from Step 1
   
   OR set individual variables:
   ```
   DB_HOST=<from Render database>
   DB_USER=<from Render database>
   DB_PASSWORD=<from Render database>
   DB_NAME=<from Render database>
   DB_PORT=5432
   DB_SSL=true
   ```

5. Click **"Create Web Service"**

### Step 4: Wait for Deployment

- Render will build and deploy your app (~3-5 minutes)
- Your app will be live at: `https://evlocator.onrender.com` (or similar)

**Note**: Free tier sleeps after 15 minutes of inactivity. First request after sleep takes ~30 seconds.

## Local Development

1. Install PostgreSQL locally

2. Install dependencies:
   ```bash
   npm install
   ```

3. Create a `.env` file (use `.env.example` as template)

4. Create database and table:
   ```sql
   CREATE DATABASE charging_stations_db;
   
   CREATE TABLE charging_stations (
     id SERIAL PRIMARY KEY,
     latitude DECIMAL(10, 8) NOT NULL,
     longitude DECIMAL(11, 8) NOT NULL,
     name VARCHAR(255) NOT NULL,
     address TEXT,
     image_url TEXT
   );
   ```

5. Start the server:
   ```bash
   npm start
   ```

6. Access at `http://localhost:3000`

## License
ISC
