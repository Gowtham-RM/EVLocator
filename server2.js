// server.js - API to fetch charging stations
const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

// Database connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root', // Replace with your MySQL username
  password: '', // Replace with your MySQL password
  database: 'ev_charge_loc' // Replace with your database name
});

db.connect((err) => {
  if (err) {
    console.error('Database connection failed:', err);
    return;
  }
  console.log('Connected to database.');
});

// API to fetch charging station data
app.get('/api/charging-stations', (req, res) => {
  const query = 'SELECT latitude AS lat, longitude AS lng, st_name AS name, st_loc AS address, connectors AS connectors FROM evadmin';

  db.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching data:', err);
      res.status(500).send('Error fetching data.');
      return;
    }
     console.log('Raw data from database:', results);
     const stations = results.map(station => ({
      lat: station.lat,
      lng: station.lng,
      name: station.name,
      address: station.address,
      connectors: station.connectors  // Handle null/undefined cases
    }));
    

    res.json(stations);
  });
});

// Start the server
const PORT = 3003;
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
