// server.js - API backed by PostgreSQL
const express = require("express");
const { Pool } = require("pg");
const cors = require("cors");

const app = express();
app.use(cors());
app.use(express.json());

const pool = new Pool(
  process.env.DATABASE_URL
    ? { connectionString: process.env.DATABASE_URL, ssl: { rejectUnauthorized: false } }
    : {
        host: process.env.DB_HOST || "localhost",
        user: process.env.DB_USER || "postgres",
        password: process.env.DB_PASSWORD || "",
        database: process.env.DB_NAME || "charging_stations_db",
        port: process.env.DB_PORT || 5432,
        ssl: process.env.DB_SSL === "true" ? { rejectUnauthorized: false } : false
      }
);

app.get("/", (req, res) => {
  res.send("API running. Try GET /api/charging-stations");
});

app.get("/api/charging-stations", async (req, res) => {
  try {
    const result = await pool.query(
      "SELECT st_name, st_loc, latitude, longitude, connectors FROM public.evadmin ORDER BY st_name"
    );

    const stations = result.rows.map((row) => ({
      lat: Number(row.latitude),
      lng: Number(row.longitude),
      name: row.st_name,
      address: row.st_loc,
      connectors: row.connectors || "Connectors not specified",
      image_url: null
    }));

    res.json(stations);
  } catch (err) {
    console.error("Error fetching data:", err);
    res.status(500).send("Error fetching data.");
  }
});

app.post("/api/add-charging-station", async (req, res) => {
  const { latitude, longitude, name, address, connectors } = req.body;

  try {
    const insertQuery = `
      INSERT INTO public.evadmin (st_name, st_loc, latitude, longitude, connectors)
      VALUES ($1, $2, $3, $4, $5)
      RETURNING st_name, st_loc, latitude, longitude, connectors;
    `;

    const result = await pool.query(insertQuery, [name, address, latitude, longitude, connectors]);

    const row = result.rows[0];
    const station = {
      lat: Number(row.latitude),
      lng: Number(row.longitude),
      name: row.st_name,
      address: row.st_loc,
      connectors: row.connectors || "Connectors not specified",
      image_url: null
    };

    res.json({ message: "Charging station added successfully.", data: station });
  } catch (err) {
    console.error("Error inserting data:", err);
    res.status(500).send("Error inserting data.");
  }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
