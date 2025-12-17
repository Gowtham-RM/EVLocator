const express = require('express');
const { Pool } = require('pg');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

// Database connection - supports DATABASE_URL or individual variables
const pool = new Pool(
  process.env.DATABASE_URL
    ? {
        connectionString: process.env.DATABASE_URL,
        ssl: { rejectUnauthorized: false }
      }
    : {
        host: process.env.DB_HOST || 'localhost',
        user: process.env.DB_USER || 'postgres',
        password: process.env.DB_PASSWORD || "",
        database: process.env.DB_NAME || 'charging_stations_db',
        port: process.env.DB_PORT || 5432,
        ssl: process.env.DB_SSL === 'true' ? { rejectUnauthorized: false } : false
      }
);

// Test database connection
pool.connect((err, client, release) => {
  if (err) {
    console.error('Database connection failed:', err);
    return;
  }
  console.log('Connected to PostgreSQL database.');
  release();
});

// Fetch all charging stations
app.get('/api/charging-stations', async (req, res) => {
  try {
    const query = 'SELECT * FROM charging_stations';
    const result = await pool.query(query);
    res.json(result.rows);
  } catch (err) {
    console.error(err);
    res.status(500).send('Error fetching data.');
  }
});

// Add a new charging station
app.post('/api/add-charging-station', async (req, res) => {
  const { latitude, longitude, name, address, image_url } = req.body;

  try {
    const query = `
      INSERT INTO charging_stations (latitude, longitude, name, address, image_url) 
      VALUES ($1, $2, $3, $4, $5)
      RETURNING *
    `;

    const result = await pool.query(query, [latitude, longitude, name, address, image_url]);
    res.json({ message: 'Charging station added successfully.', data: result.rows[0] });
  } catch (err) {
    console.error(err);
    res.status(500).send('Error inserting data.');
  }
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
