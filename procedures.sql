-- Stored Procedure: Add or Update Staff
CREATE OR REPLACE PROCEDURE add_or_update_staff(
    p_staff_number VARCHAR(10),
    p_first_name VARCHAR(50),
    p_last_name VARCHAR(50),
    p_address TEXT,
    p_telephone VARCHAR(20),
    p_date_of_birth DATE,
    p_sex CHAR(1),
    p_nin VARCHAR(15),
    p_position VARCHAR(50),
    p_current_salary DECIMAL(10,2),
    p_salary_scale VARCHAR(20),
    p_payment_type CHAR(1),
    p_contract_type CHAR(1),
    p_hours_per_week DECIMAL(5,2)
)
LANGUAGE plpgsql
AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM staff WHERE staff_number = p_staff_number) THEN
        UPDATE staff
        SET first_name = p_first_name,
            last_name = p_last_name,
            address = p_address,
            telephone = p_telephone,
            date_of_birth = p_date_of_birth,
            sex = p_sex,
            nin = p_nin,
            position = p_position,
            current_salary = p_current_salary,
            salary_scale = p_salary_scale,
            payment_type = p_payment_type,
            contract_type = p_contract_type,
            hours_per_week = p_hours_per_week
        WHERE staff_number = p_staff_number;
    ELSE
        INSERT INTO staff (
            staff_number, first_name, last_name, address, telephone, date_of_birth, sex,
            nin, position, current_salary, salary_scale, payment_type, contract_type, hours_per_week
        ) VALUES (
            p_staff_number, p_first_name, p_last_name, p_address, p_telephone, p_date_of_birth, p_sex,
            p_nin, p_position, p_current_salary, p_salary_scale, p_payment_type, p_contract_type, p_hours_per_week
        );
    END IF;
END;
$$;

-- Sample Call
CALL add_or_update_staff(
    'STF001', 'Ana', 'Reyes', '123 Hospital St', '09171234567', '1985-07-21', 'F', 
    'NIN12345678', 'Nurse', 25000.00, 'Scale A', 'M', 'P', 40.00
);



-- STORED PROCEDURE: Insert or update patient record
CREATE OR REPLACE PROCEDURE upsert_patient(
    p_patient_number VARCHAR,
    p_first_name VARCHAR,
    p_last_name VARCHAR,
    p_address TEXT,
    p_telephone VARCHAR,
    p_date_of_birth DATE,
    p_sex CHAR,
    p_marital_status VARCHAR,
    p_date_registered DATE
)
LANGUAGE plpgsql
AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM patient WHERE patient_number = p_patient_number) THEN
        UPDATE patient
        SET first_name = p_first_name,
            last_name = p_last_name,
            address = p_address,
            telephone = p_telephone,
            date_of_birth = p_date_of_birth,
            sex = p_sex,
            marital_status = p_marital_status,
            date_registered = p_date_registered
        WHERE patient_number = p_patient_number;
    ELSE
        INSERT INTO patient (
            patient_number, first_name, last_name, address, telephone,
            date_of_birth, sex, marital_status, date_registered
        ) VALUES (
            p_patient_number, p_first_name, p_last_name, p_address, p_telephone,
            p_date_of_birth, p_sex, p_marital_status, p_date_registered
        );
    END IF;
END;
$$;

-- TEST CALL
CALL upsert_patient('P1002', 'Alice', 'Reyes', 'Cebu City', '09999888877', '1988-12-01', 'F', 'Married', CURRENT_DATE);


-- STORED PROCEDURE: Insert or update inpatient record
CREATE OR REPLACE PROCEDURE upsert_inpatient(
    p_patient_id INT,
    p_ward_id INT,
    p_bed_number INT,
    p_waiting_list_date DATE,
    p_date_in_ward DATE,
    p_expected_leave DATE,
    p_actual_leave DATE,
    p_duration INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    IF EXISTS (
        SELECT 1 FROM inpatient
        WHERE patient_id = p_patient_id
          AND ward_id = p_ward_id
          AND bed_number = p_bed_number
    ) THEN
        UPDATE inpatient
        SET date_placed_on_waiting_list = p_waiting_list_date,
            date_placed_in_ward = p_date_in_ward,
            expected_leave_date = p_expected_leave,
            actual_leave_date = p_actual_leave,
            expected_duration_days = p_duration
        WHERE patient_id = p_patient_id
          AND ward_id = p_ward_id
          AND bed_number = p_bed_number;
    ELSE
        INSERT INTO inpatient (
            patient_id, ward_id, bed_number,
            date_placed_on_waiting_list, date_placed_in_ward,
            expected_leave_date, actual_leave_date, expected_duration_days
        ) VALUES (
            p_patient_id, p_ward_id, p_bed_number,
            p_waiting_list_date, p_date_in_ward,
            p_expected_leave, p_actual_leave, p_duration
        );
    END IF;
END;
$$;

-- TEST CALL
CALL upsert_inpatient(1, 1, 2, CURRENT_DATE - 5, CURRENT_DATE - 3, CURRENT_DATE + 7, NULL, 10);


CREATE OR REPLACE PROCEDURE add_medication_for_patient(
    p_patient_id INT,
    p_drug_id INT,
    p_units_per_day INT,
    p_method VARCHAR,
    p_start DATE,
    p_finish DATE
)
AS $$
BEGIN
    INSERT INTO medication (patient_id, drug_id, units_per_day, method_of_administration, start_date, finish_date)
    VALUES (p_patient_id, p_drug_id, p_units_per_day, p_method, p_start, p_finish);
END;
$$ LANGUAGE plpgsql;

-- Test
CALL add_medication_for_patient(1, 1, 2, 'Oral', '2025-05-27', '2025-06-10');

CREATE OR REPLACE PROCEDURE add_supplier(
    p_supplier_number VARCHAR,
    p_supplier_name VARCHAR,
    p_address TEXT,
    p_telephone VARCHAR,
    p_fax VARCHAR
)
AS $$
BEGIN
    INSERT INTO supplier (supplier_number, supplier_name, address, telephone, fax)
    VALUES (p_supplier_number, p_supplier_name, p_address, p_telephone, p_fax);
END;
$$ LANGUAGE plpgsql;

CALL add_supplier('SUP123', 'MediSupply Inc.', '123 Health Blvd.', '09171234567', '123-4567');

