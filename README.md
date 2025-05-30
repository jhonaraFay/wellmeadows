# Wellmeadows Hospital PostgreSQL Functions and Procedures

This project contains functions, stored procedures, views, and xml for managing staff, patients, medications, suppliers, and inpatients within the Wellmeadows Hospital database system.

## 📌 Features

The following operations are implemented:

### 🔍 Functions

#### `get_staff_by_qualification_or_experience(search_term VARCHAR)`
- Retrieves staff based on their qualifications or past work experience.
- **Example Call:**
  ```sql
  SELECT * FROM get_staff_by_qualification_or_experience('Nurse');

#### `get_medications_by_patient(p_patient_id INT)`
- Produce a report listing the details of medication for a particular patient
- **Example Call:**
  ```sql
  SELECT * FROM get_medications_by_patient(1);

#### `submit_requisition_with_items(p_ward_id INTEGER,p_staff_id INTEGER,p_requisition_date DATE,p_drugs INTEGER[][2],p_supplies INTEGER[][2],p_delivery_date DATE DEFAULT NULL)`
- Adds a new requisition to the system.
- **Example Call:**
  ```sql
  SELECT submit_requisition_with_items(
    1,                                -- ward_id
    2,                                -- staff_id
    '2025-05-29',                     -- requisition_date
    ARRAY[[1, 10], [3, 5]],           -- p_drugs (drug_id, quantity)
    NULL,                             -- p_supplies (item_id, quantity)
    '2025-06-01');                     -- delivery_date)

### 🔍 Procedures

#### `add_or_update_staff(p_staff_number VARCHAR(10),p_first_name VARCHAR(50),p_last_name VARCHAR(50),p_addressTEXT,p_telephone VARCHAR(20),p_date_of_birth DATE,p_sex CHAR(1),p_nin VARCHAR(15),p_position VARCHAR(50),p_current_salary DECIMAL(10,2),p_salary_scale VARCHAR(20),p_payment_type CHAR(1),p_contract_type CHAR(1),p_hours_per_week DECIMAL(5,2))`
- Retrieves staff based on their qualifications or past work experience.
- **Example Call:**
  ```sql
  CALL add_or_update_staff(
    'STF001', 'Ana', 'Reyes', '123 Hospital St', '09171234567', '1985-07-21', 'F', 
    'NIN12345678', 'Nurse', 25000.00, 'Scale A', 'M', 'P', 40.00);

#### `upsert_patient(p_patient_number VARCHAR,p_first_name VARCHAR,p_last_name VARCHAR,p_address TEXT,p_telephone VARCHAR,p_date_of_birth DATE,p_sex CHAR,p_marital_status VARCHAR,p_date_registered DATE)`
- Inserts or updates a patient record by patient_number.
- **Example Call:**
  ```sql
  CALL upsert_patient('P1002', 'Alice', 'Reyes', 'Cebu City', '09999888877', '1988-12-01', 'F', 
  'Married', CURRENT_DATE);

#### `upsert_inpatient(p_patient_id INT,p_ward_id INT,p_bed_number INT,p_waiting_list_date DATE,p_date_in_ward DATE,p_expected_leave DATE,p_actual_leave DATE,p_duration INT)`
- Inserts or updates inpatient admission data.
- **Example Call:**
  ```sql
  CALL upsert_inpatient(1, 1, 2, CURRENT_DATE - 5, CURRENT_DATE - 3, CURRENT_DATE + 7, NULL, 10);

#### `add_medication_for_patient(p_patient_id INT,p_drug_id INT,p_units_per_day INT,p_method VARCHAR,p_start DATE,p_finish DATE)`
- Assigns medication to a patient
- **Example Call:**
  ```sql
  CALL add_medication_for_patient(1, 1, 2, 'Oral', '2025-05-27', '2025-06-10');

#### `add_supplier(p_supplier_number VARCHAR,p_supplier_name VARCHAR,p_address TEXT,p_telephone VARCHAR,p_fax VARCHAR)`
- Adds a new supplier to the system.
- **Example Call:**
  ```sql
  CALL add_supplier('SUP123', 'MediSupply Inc.', '123 Health Blvd.', '09171234567', '123-4567');


### 🔍 Views

#### `view_staff_ward_allocation`
- Lists staff assigned to wards with shift and week.
- **Example Call:**
  ```sql
  SELECT * FROM view_staff_ward_allocation;

#### `view_outpatient_patients`
- Displays patients scheduled for outpatient appointments.
- **Example Call:**
  ```sql
  SELECT * FROM view_outpatient_patients;

#### `patients_currently_in_ward`
- Shows patients currently occupying beds in wards.
- **Example Call:**
  ```sql
  SELECT * FROM patients_currently_in_ward WHERE ward_id = 1;

#### `supplies_by_ward`
- Summarizes supply items requested per ward.
- **Example Call:**
  ```sql
  SELECT * FROM supplies_by_ward WHERE ward_id = 1;

#### `view_full_requisitions`
- Displays requisitions.
- **Example Call:**
  ```sql
  SELECT * FROM view_full_requisitions ORDER BY requisition_date DESC;

### 🔍 XML

#### `export_staff_xml(search_term VARCHAR)`
- Returns XML data of staff matching a keyword in their qualification or experience.
- **Example Call:**
  ```sql
  SELECT export_staff_xml('nurse');

#### `get_patients_in_ward_xml(p_ward_id INT)`
- Returns XML data for patients currently admitted in a specific ward.
- **Example Call:**
  ```sql
  SELECT get_patients_in_ward_xml(1);

#### `get_medications_for_patient_xml(p_patient_id INT)`
- Returns XML-formatted list of all medications prescribed to a specific patient.
- **Example Call:**
  ```sql
  SELECT get_medications_for_patient_xml(1);

#### `get_supplies_per_ward_xml()`
- Returns all supplies per ward in structured XML format.
- **Example Call:**
  ```sql
  SELECT get_supplies_per_ward_xml();

#### `get_outpatient_referrals_xml()`
- Returns XML data of outpatient referrals with appointment schedules.
- **Example Call:**
  ```sql
  SELECT get_outpatient_referrals_xml();

#### `get_staff_per_ward_xml()`
- Returns XML data listing staff per ward including their shift.
- **Example Call:**
  ```sql
  SELECT get_staff_per_ward_xml();
