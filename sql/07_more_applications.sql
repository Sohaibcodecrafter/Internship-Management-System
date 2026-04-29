-- 6 additional applications to populate admin recent activity
INSERT INTO applications (student_id, internship_id, cover_note, status, applied_at)
VALUES
(3, 4, 'I have strong content writing skills developed through my university newspaper and two freelance client projects.', 'pending', NOW()),
(5, 5, 'IT support and networking are my strengths. I have hands-on experience setting up LAN environments in my university lab.', 'pending', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(6, 9, 'UI/UX design bridges my engineering and creative sides perfectly. I have designed three full Figma prototypes.', 'shortlisted', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(7, 10, 'Graphic design has been my passion since A-levels. I have created brand identities for two student societies.', 'pending', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(4, 6, 'Business analysis perfectly aligns with my BS IT curriculum at COMSATS. I have completed requirement-gathering assignments.', 'pending', DATE_SUB(NOW(), INTERVAL 4 DAY)),
(10, 8, 'The ML Research Intern role directly matches my final year project on neural network optimisation at ITU.', 'accepted', DATE_SUB(NOW(), INTERVAL 5 DAY));

-- Placement for the accepted application
INSERT INTO placements (application_id, start_date, end_date)
SELECT application_id, '2026-06-01', '2026-10-01'
FROM applications
WHERE student_id = 10 AND internship_id = 8 AND status = 'accepted'
LIMIT 1;
