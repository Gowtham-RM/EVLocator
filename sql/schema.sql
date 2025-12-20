CREATE TABLE IF NOT EXISTS public.users (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    vehicle_type TEXT,
    connector_type TEXT,
    city TEXT,
    state TEXT,
    zip TEXT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS public.evadmin (
    id SERIAL PRIMARY KEY,
    st_name TEXT NOT NULL,
    st_loc TEXT NOT NULL,
    latitude TEXT NOT NULL,
    longitude TEXT NOT NULL,
    connectors TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS public.slot (
    slot_id SERIAL PRIMARY KEY,
    ev_type TEXT NOT NULL,
    ev_make TEXT NOT NULL,
    booking_date DATE NOT NULL,
    time_slot TEXT NOT NULL,
    charging_type TEXT NOT NULL,
    phone_number TEXT NOT NULL,
    email TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    UNIQUE (phone_number, email, booking_date, time_slot)
);

CREATE TABLE IF NOT EXISTS public.station_requests (
    id SERIAL PRIMARY KEY,
    st_name TEXT NOT NULL,
    st_loc TEXT NOT NULL,
    latitude TEXT NOT NULL,
    longitude TEXT NOT NULL,
    connectors TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);
