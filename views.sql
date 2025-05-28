-- VIEW: Staff allocated to wards
CREATE OR REPLACE VIEW view_staff_ward_allocation AS
SELECT 
    s.staff_id,
    s.first_name || ' ' || s.last_name AS full_name,
    swa.ward_id,
    w.ward_name,
    swa.shift,
    swa.week_beginning
FROM staff s
JOIN staff_ward_allocation swa ON s.staff_id = swa.staff_id
JOIN ward w ON swa.ward_id = w.ward_id;

-- TEST CALL
SELECT * FROM view_staff_ward_allocation;


-- VIEW: Patients referred to outpatient clinic
CREATE OR REPLACE VIEW view_outpatient_patients AS
SELECT 
    p.patient_id,
    p.first_name || ' ' || p.last_name AS full_name,
    o.appointment_datetime
FROM outpatient o
JOIN patient p ON o.patient_id = p.patient_id;

-- TEST CALL
SELECT * FROM view_outpatient_patients;


CREATE OR REPLACE VIEW patients_currently_in_ward AS
SELECT
    i.inpatient_id,
    p.patient_id,
    p.first_name,
    p.last_name,
    i.ward_id,
    w.ward_name,
    i.bed_number,
    i.date_placed_in_ward,
    i.expected_leave_date
FROM inpatient i
JOIN patient p ON p.patient_id = i.patient_id
JOIN ward w ON w.ward_id = i.ward_id
WHERE i.actual_leave_date IS NULL;

-- Test
SELECT * FROM patients_currently_in_ward WHERE ward_id = 1;


CREATE OR REPLACE VIEW supplies_by_ward AS
SELECT
    r.ward_id,
    w.ward_name,
    ri.item_id,
    si.item_name,
    SUM(ri.quantity) AS total_supplied
FROM requisition r
JOIN requisition_item ri ON r.requisition_id = ri.requisition_id
JOIN supply_item si ON si.item_id = ri.item_id
JOIN ward w ON w.ward_id = r.ward_id
GROUP BY r.ward_id, w.ward_name, ri.item_id, si.item_name;

-- Test
SELECT * FROM supplies_by_ward WHERE ward_id = 1;
