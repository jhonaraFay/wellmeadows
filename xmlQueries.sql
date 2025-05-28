CREATE OR REPLACE FUNCTION export_staff_xml(search_term VARCHAR)
RETURNS XML AS $$
DECLARE
    result XML;
BEGIN
    SELECT xmlagg(
        xmlelement(name staff,
            xmlforest(
                s.staff_id,
                s.first_name,
                s.last_name,
                q.type AS qualification,
                we.position AS experience
            )
        )
    ) INTO result
    FROM staff s
    LEFT JOIN qualification q ON s.staff_id = q.staff_id
    LEFT JOIN work_experience we ON s.staff_id = we.staff_id
    WHERE q.type ILIKE '%' || search_term || '%'
       OR we.position ILIKE '%' || search_term || '%';

    RETURN result;
END;
$$ LANGUAGE plpgsql;

SELECT export_staff_xml('nurse');


CREATE OR REPLACE FUNCTION get_patients_in_ward_xml(p_ward_id INT)
RETURNS XML AS $$
DECLARE
    result XML;
BEGIN
    SELECT xmlagg(
        xmlelement(name patient,
            xmlforest(
                p.patient_id,
                p.first_name,
                p.last_name,
                ip.date_placed_in_ward AS admission_date,
                ip.actual_leave_date
            )
        )
    ) INTO result
    FROM inpatient ip
    JOIN patient p ON ip.patient_id = p.patient_id
    WHERE ip.ward_id = p_ward_id
      AND ip.actual_leave_date IS NULL;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

SELECT get_patients_in_ward_xml(1);


CREATE OR REPLACE FUNCTION get_medications_for_patient_xml(p_patient_id INT)
RETURNS XML AS $$
DECLARE
    result XML;
BEGIN
    SELECT xmlagg(
        xmlelement(name medication,
            xmlforest(
                m.medication_id,
                p.patient_id,
                ph.drug_name,
                m.units_per_day,
                m.method_of_administration,
                m.start_date,
                m.finish_date
            )
        )
    ) INTO result
    FROM medication m
    JOIN patient p ON m.patient_id = p.patient_id
    JOIN pharmaceutical ph ON m.drug_id = ph.drug_id
    WHERE m.patient_id = p_patient_id;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

SELECT get_medications_for_patient_xml(1);


CREATE OR REPLACE FUNCTION get_supplies_per_ward_xml()
RETURNS XML AS $$
DECLARE
    result XML;
BEGIN
    SELECT xmlagg(
        xmlelement(name ward,
            xmlattributes(w.ward_id, w.ward_name),
            (
                SELECT xmlagg(
                    xmlelement(name supply,
                        xmlforest(
                            si.item_id,
                            si.item_name AS supply_name,
                            ri.quantity
                        )
                    )
                )
                FROM requisition r
                JOIN requisition_item ri ON r.requisition_id = ri.requisition_id
                JOIN supply_item si ON ri.item_id = si.item_id
                WHERE r.ward_id = w.ward_id
            )
        )
    ) INTO result
    FROM ward w;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

SELECT get_supplies_per_ward_xml();


CREATE OR REPLACE FUNCTION get_outpatient_referrals_xml()
RETURNS XML AS $$
DECLARE
    result XML;
BEGIN
    SELECT xmlagg(
        xmlelement(name outpatient,
            xmlforest(
                op.outpatient_id,
                p.first_name,
                p.last_name,
                op.appointment_datetime
            )
        )
    ) INTO result
    FROM outpatient op
    JOIN patient p ON op.patient_id = p.patient_id;

    RETURN result;
END;
$$ LANGUAGE plpgsql;


SELECT get_outpatient_referrals_xml();

CREATE OR REPLACE FUNCTION get_staff_per_ward_xml()
RETURNS XML AS $$
DECLARE
    result XML;
BEGIN
    SELECT xmlagg(
        xmlelement(name ward,
            xmlattributes(w.ward_id, w.ward_name),
            (
                SELECT xmlagg(
                    xmlelement(name staff,
                        xmlforest(
                            s.staff_id,
                            s.first_name,
                            s.last_name,
                            sw.shift -- corrected from role to shift
                        )
                    )
                )
                FROM staff_ward_allocation sw
                JOIN staff s ON sw.staff_id = s.staff_id
                WHERE sw.ward_id = w.ward_id
            )
        )
    ) INTO result
    FROM ward w;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

SELECT get_staff_per_ward_xml();
