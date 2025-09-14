const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

// Database connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: "",
  database: 'charging_stations_db'
});

db.connect((err) => {
  if (err) {
    console.error('Database connection failed:', err);
    return;
  }
  console.log('Connected to database.');
});

// Fetch all charging stations
app.get('/api/charging-stations', (req, res) => {
  const query = 'SELECT * FROM charging_stations';
  db.query(query, (err, results) => {
    if (err) {
      res.status(500).send('Error fetching data.');
      return;
    }
    res.json(results);
  });
});

// Add a new charging station
app.post('/api/add-charging-station', (req, res) => {
  const { latitude, longitude, name, address, image_url } = req.body;

  const query = `
    INSERT INTO charging_stations (latitude, longitude, name, address, image_url) 
    VALUES (?, ?, ?, ?, ?)
  `;

  db.query(query, [latitude, longitude, name, address, image_url], (err, results) => {
    if (err) {
      res.status(500).send('Error inserting data.');
      return;
    }
    res.send('Charging station added successfully.');
  });
});

// Start server
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
