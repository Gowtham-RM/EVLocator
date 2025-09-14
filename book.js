// BookingForm.js
import React, { useState } from 'react';
import axios from 'axios';

function BookingForm() {
  const [timeSlot, setTimeSlot] = useState('');
  const [stationId, setStationId] = useState('');

  const handleBooking = () => {
    axios.post('/api/book', { stationId, timeSlot })
      .then(response => {
        alert('Booking successful!');
      })
      .catch(error => {
        alert('Error booking station!');
      });
  };

  return (
    <div>
      <h2>Book Charging Slot</h2>
      <input type="text" placeholder="Station ID" onChange={e => setStationId(e.target.value)} />
      <input type="time" onChange={e => setTimeSlot(e.target.value)} />
      <button onClick={handleBooking}>Book Now</button>
    </div>
  );
}

export default BookingForm;
// Booking API
const bookings = [];

app.post('/api/book', (req, res) => {
  const { stationId, timeSlot } = req.body;
  bookings.push({ stationId, timeSlot, status: 'booked' });
  res.status(200).send('Booking confirmed!');
});
