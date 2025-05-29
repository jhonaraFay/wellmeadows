INSERT INTO ward (ward_name, location, total_beds, telephone_extension) VALUES
('General Medicine', '1st Floor', 30, '1234'),
('Surgery', '2nd Floor', 25, '5678');
INSERT INTO staff (staff_number, first_name, last_name, address, telephone, date_of_birth, sex, nin, position, current_salary, salary_scale, payment_type, contract_type, hours_per_week) VALUES
('ST001', 'John', 'Doe', '123 Main St', '555-1234', '1980-01-15', 'M', 'NIN123456789', 'Nurse', 35000.00, 'S1', 'M', 'P', 40),
('ST002', 'Jane', 'Smith', '456 Oak Ave', '555-5678', '1985-03-22', 'F', 'NIN987654321', 'Doctor', 75000.00, 'S2', 'M', 'P', 40);
INSERT INTO qualification (staff_id, type, date_obtained, institution) VALUES
(1, 'Bachelor of Nursing', '2005-06-15', 'Health University'),
(2, 'Doctor of Medicine', '2010-05-20', 'Medical School');
INSERT INTO work_experience (staff_id, position, start_date, finish_date, organization) VALUES
(1, 'Staff Nurse', '2005-07-01', '2010-12-31', 'City Hospital'),
(2, 'Resident Doctor', '2010-06-01', '2015-12-31', 'General Hospital');
INSERT INTO staff_ward_allocation (staff_id, ward_id, shift, week_beginning) VALUES
(1, 1, 'Early', '2025-05-26'),
(2, 2, 'Late', '2025-05-26');
INSERT INTO patient (patient_number, first_name, last_name, address, telephone, date_of_birth, sex, marital_status, date_registered) VALUES
('P001', 'Alice', 'Johnson', '789 Pine St', '555-7890', '1990-04-10', 'F', 'Single', '2025-01-15'),
('P002', 'Bob', 'Williams', '321 Maple Rd', '555-2345', '1982-08-18', 'M', 'Married', '2025-02-20');
INSERT INTO next_of_kin (patient_id, full_name, relationship, address, telephone) VALUES
(1, 'Mary Johnson', 'Mother', '789 Pine St', '555-7891'),
(2, 'Susan Williams', 'Wife', '321 Maple Rd', '555-2346');
INSERT INTO local_doctor (full_name, clinic_number, address, telephone) VALUES
('Dr. Alan Grant', 'CLINIC001', '100 Medical Plaza', '555-1111'),
('Dr. Ellie Sattler', 'CLINIC002', '101 Medical Plaza', '555-2222');
INSERT INTO patient_doctor (patient_id, doctor_id) VALUES
(1, 1),
(2, 2);
INSERT INTO appointment (appointment_number, patient_id, staff_id, date_time, examination_room) VALUES
('A100', 1, 2, '2025-06-01 09:00:00', 'Room 101'),
('A101', 2, 2, '2025-06-02 14:30:00', 'Room 202');
INSERT INTO outpatient (patient_id, appointment_datetime) VALUES
(1, '2025-06-01 09:00:00'),
(2, '2025-06-02 14:30:00');
INSERT INTO inpatient (patient_id, ward_id, bed_number, date_placed_on_waiting_list, date_placed_in_ward, expected_leave_date, actual_leave_date, expected_duration_days) VALUES
(1, 1, 5, '2025-05-20', '2025-05-21', '2025-06-05', NULL, 15),
(2, 2, 10, '2025-05-22', '2025-05-23', '2025-06-07', NULL, 15);
INSERT INTO pharmaceutical (drug_number, drug_name, description, dosage, method_of_administration, quantity_in_stock, reorder_level, cost_per_unit) VALUES
('D001', 'Paracetamol', 'Pain reliever and fever reducer', '500 mg', 'Oral', 1000, 100, 0.10),
('D002', 'Amoxicillin', 'Antibiotic', '250 mg', 'Oral', 500, 50, 0.25);
INSERT INTO supply_item (item_number, item_name, item_type, description, quantity_in_stock, reorder_level, cost_per_unit) VALUES
('I001', 'Surgical Gloves', 'Surgical', 'Latex gloves', 2000, 200, 0.05),
('I002', 'Bandages', 'Non-surgical', 'Elastic bandages', 1500, 150, 0.10);
INSERT INTO medication (patient_id, drug_id, units_per_day, method_of_administration, start_date, finish_date) VALUES
(1, 1, 2, 'Oral', '2025-05-22', '2025-06-05'),
(2, 2, 3, 'Oral', '2025-05-23', '2025-06-07');
INSERT INTO supplier (supplier_number, supplier_name, address, telephone, fax) VALUES
('SUP001', 'MedSupply Inc.', '500 Supply Rd', '555-3333', '555-3334'),
('SUP002', 'HealthEquip Ltd.', '600 Equipment St', '555-4444', '555-4445');
INSERT INTO requisition (requisition_number, ward_id, staff_id, requisition_date, delivery_date) VALUES
('R100', 1, 1, '2025-05-25', '2025-05-28'),
('R101', 2, 2, '2025-05-26', '2025-05-29');
INSERT INTO requisition_item (requisition_id, item_id, quantity) VALUES
(1, 1, 20),
(2, 2, 15);
INSERT INTO requisition_drug (requisition_id, drug_id, quantity) VALUES
(1, 1, 50),
(2, 2, 30);
INSERT INTO supplier_item (supplier_id, item_id) VALUES
(1, 1),
(2, 2);
INSERT INTO supplier_drug (supplier_id, drug_id) VALUES
(1, 1),
(2, 2);
