CREATE OR REPLACE FUNCTION get_staff_by_qualification_or_experience(
    search_term VARCHAR
)
RETURNS TABLE (
    staff_id INT,
    full_name VARCHAR,
    qualification_type VARCHAR,
    experience_position VARCHAR
) AS $$
BEGIN
    RETURN QUERY
    SELECT
        s.staff_id,
        (s.first_name || ' ' || s.last_name)::VARCHAR AS full_name,
        q.type,
        we.position
    FROM staff s
    LEFT JOIN qualification q ON s.staff_id = q.staff_id
    LEFT JOIN work_experience we ON s.staff_id = we.staff_id
    WHERE q.type ILIKE '%' || search_term || '%'
       OR we.position ILIKE '%' || search_term || '%';
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_staff_by_qualification_or_experience('Nurse');


CREATE OR REPLACE FUNCTION get_medications_by_patient(p_patient_id INT)
RETURNS TABLE (
    medication_id INT,
    drug_name VARCHAR,
    units_per_day INT,
    method_of_administration VARCHAR,
    start_date DATE,
    finish_date DATE
) AS $$
BEGIN
    RETURN QUERY
    SELECT
        m.medication_id,
        d.drug_name,
        m.units_per_day,
        m.method_of_administration,
        m.start_date,
        m.finish_date
    FROM medication m
    JOIN pharmaceutical d ON d.drug_id = m.drug_id
    WHERE m.patient_id = p_patient_id;
END;
$$ LANGUAGE plpgsql;

-- Test
SELECT * FROM get_medications_by_patient(1);
