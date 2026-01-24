
INSERT INTO users (full_name, email, password, role)
VALUES ('Admin User', 'admin@example.com', 'admin123', 'admin');

INSERT INTO users (full_name, email, password, role)
VALUES 
('John Doe', 'john@example.com', 'password123', 'user'),
('Sarah Smith', 'sarah@example.com', 'password123', 'user');

INSERT INTO airports (name, code, city, country)
VALUES
('John F. Kennedy International Airport', 'JFK', 'New York', 'USA'),
('London Heathrow Airport', 'LHR', 'London', 'UK'),
('Frankfurt Airport', 'FRA', 'Frankfurt', 'Germany');

INSERT INTO flights (flight_number, departure_airport, arrival_airport, departure_time, arrival_time, price, seats_available)
VALUES
('MJ101', 1, 2, '2026-03-01 08:00:00', '2026-03-01 20:00:00', 450.00, 120),
('MJ202', 2, 3, '2026-03-02 10:00:00', '2026-03-02 13:00:00', 300.00, 95),
('MJ303', 1, 3, '2026-03-03 09:00:00', '2026-03-03 18:00:00', 510.00, 110);

INSERT INTO news (title, content)
VALUES
('New Routes for 2026!', 'MJ Airlines is excited to announce brand new international destinations.'),
('Holiday Discounts', 'Save up to 40% on selected flights this holiday season.');

INSERT INTO messages (name, email, subject, message)
VALUES
('Emily White', 'emily@example.com', 'Booking Help', 'I need assistance with my ticket.'),
('Michael Green', 'michael@example.com', 'Flight Delay', 'What is the status of flight MJ202?');
