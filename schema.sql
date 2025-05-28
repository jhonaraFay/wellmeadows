-- WARD TABLE
CREATE TABLE ward (
    ward_id SERIAL PRIMARY KEY,
    ward_name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    total_beds INTEGER NOT NULL,
    telephone_extension VARCHAR(20) NOT NULL
);

-- STAFF TABLE
CREATE TABLE staff (
    staff_id SERIAL PRIMARY KEY,
    staff_number VARCHAR(10) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    date_of_birth DATE NOT NULL,
    sex CHAR(1) CHECK (sex IN ('M', 'F')),
    nin VARCHAR(15) UNIQUE NOT NULL,
    position VARCHAR(50) NOT NULL,
    current_salary DECIMAL(10, 2) NOT NULL,
    salary_scale VARCHAR(20) NOT NULL,
    payment_type CHAR(1) CHECK (payment_type IN ('W', 'M')),
    contract_type CHAR(1) CHECK (contract_type IN ('P', 'T')),
    hours_per_week DECIMAL(5, 2) NOT NULL
);

-- QUALIFICATION TABLE
CREATE TABLE qualification (
    qualification_id SERIAL PRIMARY KEY,
    staff_id INTEGER NOT NULL,
    type VARCHAR(100) NOT NULL,
    date_obtained DATE NOT NULL,
    institution VARCHAR(100) NOT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE
);

-- WORK EXPERIENCE TABLE
CREATE TABLE work_experience (
    experience_id SERIAL PRIMARY KEY,
    staff_id INTEGER NOT NULL,
    position VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    finish_date DATE NOT NULL,
    organization VARCHAR(100) NOT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE
);

-- STAFF WARD ALLOCATION
CREATE TABLE staff_ward_allocation (
    allocation_id SERIAL PRIMARY KEY,
    staff_id INTEGER NOT NULL,
    ward_id INTEGER NOT NULL,
    shift VARCHAR(10) CHECK (shift IN ('Early', 'Late', 'Night')),
    week_beginning DATE NOT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE,
    FOREIGN KEY (ward_id) REFERENCES ward(ward_id) ON DELETE CASCADE
);

-- PATIENT
CREATE TABLE patient (
    patient_id SERIAL PRIMARY KEY,
    patient_number VARCHAR(10) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    telephone VARCHAR(20),
    date_of_birth DATE NOT NULL,
    sex CHAR(1) CHECK (sex IN ('M', 'F')),
    marital_status VARCHAR(20),
    date_registered DATE NOT NULL
);

-- NEXT OF KIN
CREATE TABLE next_of_kin (
    kin_id SERIAL PRIMARY KEY,
    patient_id INTEGER NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    relationship VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id) ON DELETE CASCADE
);

-- LOCAL DOCTOR
CREATE TABLE local_doctor (
    doctor_id SERIAL PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    clinic_number VARCHAR(20) UNIQUE NOT NULL,
    address TEXT NOT NULL,
    telephone VARCHAR(20) NOT NULL
);

-- PATIENT DOCTOR RELATIONSHIP
CREATE TABLE patient_doctor (
    pd_id SERIAL PRIMARY KEY,
    patient_id INTEGER NOT NULL,
    doctor_id INTEGER NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES local_doctor(doctor_id) ON DELETE CASCADE
);

-- APPOINTMENTS
CREATE TABLE appointment (
    appointment_id SERIAL PRIMARY KEY,
    appointment_number VARCHAR(10) UNIQUE NOT NULL,
    patient_id INTEGER NOT NULL,
    staff_id INTEGER NOT NULL,
    date_time TIMESTAMP NOT NULL,
    examination_room VARCHAR(20) NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE
);

-- OUTPATIENTS
CREATE TABLE outpatient (
    outpatient_id SERIAL PRIMARY KEY,
    patient_id INTEGER NOT NULL,
    appointment_datetime TIMESTAMP NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id) ON DELETE CASCADE
);

-- INPATIENTS
CREATE TABLE inpatient (
    inpatient_id SERIAL PRIMARY KEY,
    patient_id INTEGER NOT NULL,
    ward_id INTEGER NOT NULL,
    bed_number INTEGER NOT NULL,
    date_placed_on_waiting_list DATE NOT NULL,
    date_placed_in_ward DATE,
    expected_leave_date DATE,
    actual_leave_date DATE,
    expected_duration_days INTEGER,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (ward_id) REFERENCES ward(ward_id) ON DELETE CASCADE,
    UNIQUE (ward_id, bed_number, date_placed_in_ward)
);

-- PHARMACEUTICAL SUPPLIES
CREATE TABLE pharmaceutical (
    drug_id SERIAL PRIMARY KEY,
    drug_number VARCHAR(10) UNIQUE NOT NULL,
    drug_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    dosage VARCHAR(50) NOT NULL,
    method_of_administration VARCHAR(50) NOT NULL,
    quantity_in_stock INTEGER NOT NULL,
    reorder_level INTEGER NOT NULL,
    cost_per_unit DECIMAL(10, 2) NOT NULL
);

-- SUPPLY ITEMS
CREATE TABLE supply_item (
    item_id SERIAL PRIMARY KEY,
    item_number VARCHAR(10) UNIQUE NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    item_type VARCHAR(20) CHECK (item_type IN ('Surgical', 'Non-surgical')),
    description TEXT NOT NULL,
    quantity_in_stock INTEGER NOT NULL,
    reorder_level INTEGER NOT NULL,
    cost_per_unit DECIMAL(10, 2) NOT NULL
);

-- MEDICATION
CREATE TABLE medication (
    medication_id SERIAL PRIMARY KEY,
    patient_id INTEGER NOT NULL,
    drug_id INTEGER NOT NULL,
    units_per_day INTEGER NOT NULL,
    method_of_administration VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    finish_date DATE NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (drug_id) REFERENCES pharmaceutical(drug_id) ON DELETE CASCADE
);

-- SUPPLIERS
CREATE TABLE supplier (
    supplier_id SERIAL PRIMARY KEY,
    supplier_number VARCHAR(10) UNIQUE NOT NULL,
    supplier_name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    fax VARCHAR(20)
);

-- REQUISITIONS
CREATE TABLE requisition (
    requisition_id SERIAL PRIMARY KEY,
    requisition_number VARCHAR(20) UNIQUE NOT NULL,
    ward_id INTEGER NOT NULL,
    staff_id INTEGER NOT NULL,
    requisition_date DATE NOT NULL,
    delivery_date DATE,
    FOREIGN KEY (ward_id) REFERENCES ward(ward_id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE
);

-- REQUISITION ITEM
CREATE TABLE requisition_item (
    req_item_id SERIAL PRIMARY KEY,
    requisition_id INTEGER NOT NULL,
    item_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    FOREIGN KEY (requisition_id) REFERENCES requisition(requisition_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES supply_item(item_id) ON DELETE CASCADE
);

-- REQUISITION DRUG
CREATE TABLE requisition_drug (
    req_drug_id SERIAL PRIMARY KEY,
    requisition_id INTEGER NOT NULL,
    drug_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    FOREIGN KEY (requisition_id) REFERENCES requisition(requisition_id) ON DELETE CASCADE,
    FOREIGN KEY (drug_id) REFERENCES pharmaceutical(drug_id) ON DELETE CASCADE
);

-- SUPPLIER ITEM
CREATE TABLE supplier_item (
    supplier_item_id SERIAL PRIMARY KEY,
    supplier_id INTEGER NOT NULL,
    item_id INTEGER NOT NULL,
    FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES supply_item(item_id) ON DELETE CASCADE
);

-- SUPPLIER DRUG
CREATE TABLE supplier_drug (
    supplier_drug_id SERIAL PRIMARY KEY,
    supplier_id INTEGER NOT NULL,
    drug_id INTEGER NOT NULL,
    FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id) ON DELETE CASCADE,
    FOREIGN KEY (drug_id) REFERENCES pharmaceutical(drug_id) ON DELETE CASCADE
);

-- INDEXES
CREATE INDEX idx_staff_position ON staff(position);
CREATE INDEX idx_staff_ward ON staff_ward_allocation(ward_id, staff_id);
CREATE INDEX idx_patient_ward ON inpatient(ward_id);
CREATE INDEX idx_patient_name ON patient(last_name, first_name);
CREATE INDEX idx_medication_patient ON medication(patient_id);
CREATE INDEX idx_requisition_ward ON requisition(ward_id);
