<?php
require_once __DIR__ . '/backend/config/db.php';

/**
 * Portable Database Seeder - Restoring User-Customized Doctors
 */

try {
    // Disable foreign key checks for clean wipe (SQLite syntax)
    $conn->exec("PRAGMA foreign_keys = OFF");
    
    $conn->exec("DELETE FROM users");
    $conn->exec("DELETE FROM doctors");
    $conn->exec("DELETE FROM appointments");
    $conn->exec("DELETE FROM medicines");

    // Seed Users
    $pass = password_hash('password123', PASSWORD_DEFAULT);
    
    // User IDs: 1 (Admin), 2 (Patient), 3-11 (Doctors)
    $conn->exec("INSERT INTO users (id, fullname, username, email, password, role, subscription_plan) VALUES 
        (1, 'System Admin', 'admin', 'admin@medicare.com', '$pass', 'admin', 'elite'),
        (2, 'Saheb', 'saheb', 'saheb@gmail.com', '$pass', 'patient', 'pro'),
        (3, 'Ananya Saha', 'ananya', 'ananya@medicare.com', '$pass', 'doctor', 'elite'),
        (4, 'Subhajit Das', 'subhajit_d', 'subhajit@medicare.com', '$pass', 'doctor', 'pro'),
        (5, 'Subhojit Das', 'subhojit_d', 'subhojit@medicare.com', '$pass', 'doctor', 'pro'),
        (6, 'Subham Roy', 'subham', 'subham@medicare.com', '$pass', 'doctor', 'elite'),
        (7, 'Subhodeep Basu', 'subhodeep', 'subhodeep@medicare.com', '$pass', 'doctor', 'pro'),
        (8, 'Subhoprasad Bhattacharyya', 'subhoprasad', 'subhoprasad@medicare.com', '$pass', 'doctor', 'elite'),
        (9, 'Subrata Karmakar', 'subrata', 'subrata@medicare.com', '$pass', 'doctor', 'pro'),
        (10, 'Sudipa Deb', 'sudipa', 'sudipa@medicare.com', '$pass', 'doctor', 'pro'),
        (11, 'Supriyo Bhattacharyya', 'supriyo', 'supriyo@medicare.com', '$pass', 'doctor', 'elite')");

    // Seed Doctors with local image assets
    $conn->exec("INSERT INTO doctors (id, name, contact, specialization, experience, bio, is_elite, image) VALUES 
        (3, 'Ananya Saha', 'ananya@medicare.com', 'Neurology', 12, 'Leading specialist in neural sciences and mental wellbeing.', 1, 'assets/images/Ananya.jpg'),
        (4, 'Subhajit Das', 'subhajit@medicare.com', 'Cardiology', 15, 'Expert in cardiovascular surgery and preventive heart care.', 0, 'assets/images/Subhajit.jpeg'),
        (5, 'Subhojit Das', 'subhojit@medicare.com', 'Pediatrics', 10, 'Compassionate care for infants, children, and adolescents.', 0, 'assets/images/Subhojit.jpeg'),
        (6, 'Subham Roy', 'subham@medicare.com', 'Orthopedics', 8, 'Specializing in sports injuries and bone reconstruction.', 1, 'assets/images/Subham.jpeg'),
        (7, 'Subhodeep Basu', 'subhodeep@medicare.com', 'Dermatology', 7, 'Advanced skin care and dermatological surgery specialist.', 0, 'assets/images/SubhodeepBasu.jpeg'),
        (8, 'Subhoprasad Bhattacharyya', 'subhoprasad@medicare.com', 'Oncology', 20, 'Distinguished expert in cancer research and clinical oncology.', 1, 'assets/images/Subhoprasad.png'),
        (9, 'Subrata Karmakar', 'subrata@medicare.com', 'Gastroenterology', 14, 'Professional in digestive diseases and liver care.', 0, 'assets/images/Subrata.jpeg'),
        (10, 'Sudipa Deb', 'sudipa@medicare.com', 'Gynecology', 12, 'Comprehensive maternal and reproductive health specialist.', 0, 'assets/images/Sudipa.jpg'),
        (11, 'Supriyo Bhattacharyya', 'supriyo@medicare.com', 'Psychiatry', 18, 'Expert in clinical psychology and behavioral health therapy.', 1, 'assets/images/Supriyo.jpeg')");

    // Seed 100+ Medicines
    $medicinesData = [
        ["Paracetamol", "Analgesic", "Relieves pain and fever.", "Headache, muscle pain, arthritis, backache, toothache, colds, fever.", "Nausea, stomach pain, loss of appetite.", "Adults and children over 2 months.", "tablets_white_round"],
        ["Ibuprofen", "NSAID", "Reduces hormones that cause inflammation.", "Pain, fever, and inflammation caused by many conditions.", "Upset stomach, nausea, headache.", "Adults and children over 6 months.", "tablets_yellow_oval"],
        ["Naproxen", "NSAID", "Long-acting anti-inflammatory drug.", "Arthritis, menstrual cramps, muscle aches, dental pain.", "Dizziness, drowsiness, stomach pain.", "Adults and children as prescribed.", "tablets_large_oblong_white"],
        ["Aspirin", "Analgesic", "Pain reliever and blood thinner.", "Fever, pain, inflammation, and heart attack prevention.", "Stomach upset, heartburn.", "Adults only.", "tablets_white_round"],
        ["Diclofenac", "NSAID", "Potent anti-inflammatory for joint pain.", "Osteoarthritis, rheumatoid arthritis, acute pain.", "Abdominal pain, constipation.", "Adults.", "tablets_pink_round_small"],
        ["Amoxicillin", "Antibiotic", "Penicillin-type antibiotic.", "Bacterial infections such as pneumonia, throat infections, UTI.", "Rash, diarrhea.", "Patients with bacterial infections.", "capsules_blue_white"],
        ["Azithromycin", "Antibiotic", "Macrolide antibiotic.", "Respiratory infections, skin infections, ear infections.", "Diarrhea, nausea.", "Adults and children.", "capsules_red_black"],
        ["Ciprofloxacin", "Antibiotic", "Fluoroquinolone antibiotic.", "Urinary tract, skin, and bone infections.", "Nausea, diarrhea.", "Adults.", "tablets_large_oblong_white"],
        ["Doxycycline", "Antibiotic", "Tetracycline antibiotic.", "Acne, malaria prevention, bacterial infections.", "Nausea, sun sensitivity.", "Adults and children over 8 years.", "capsules_green_white_medical"],
        ["Cephalexin", "Antibiotic", "Cephalosporin antibiotic.", "Skin, bone, ear, and urinary tract infections.", "Diarrhea, indigestion.", "Patients with bacterial infections.", "capsules_blue_white"],
        ["Amlodipine", "Antihypertensive", "Calcium channel blocker.", "High blood pressure and chest pain.", "Swelling, dizziness.", "Adults.", "tablets_white_round"],
        ["Lisinopril", "ACE Inhibitor", "Lowers blood pressure.", "Hypertension and heart failure.", "Cough, dizziness.", "Adults.", "tablets_pink_round_small"],
        ["Atorvastatin", "Statin", "Reduces 'bad' cholesterol.", "High cholesterol and prevention of heart disease.", "Muscle pain, joint pain.", "Adults.", "tablets_yellow_oval"],
        ["Metoprolol", "Beta-Blocker", "Slows heart rate.", "Hypertension, chest pain.", "Dizziness, fatigue.", "Adults.", "tablets_white_round"],
        ["Losartan", "ARB", "Angiotensin receptor blocker.", "Hypertension and kidney disease.", "Dizziness, back pain.", "Adults.", "tablets_white_round"],
        ["Furosemide", "Diuretic", "Reduces fluid retention.", "Edema, heart failure, high BP.", "Dehydration, dizziness.", "Adults.", "tablets_white_round"],
        ["Omeprazole", "Antacid", "Proton pump inhibitor.", "Heartburn, acid reflux, stomach ulcers.", "Headache, diarrhea.", "Adults and children over 1 year.", "bottle_white_sealed"],
        ["Pantoprazole", "Antacid", "Reduces stomach acid.", "Erosive esophagitis, Zollinger-Ellison syndrome.", "Headache, joint pain.", "Adults.", "tablets_yellow_oval"],
        ["Famotidine", "H2 Blocker", "Reduces stomach acid.", "Heartburn, indigestion, ulcers.", "Constipation, headache.", "Adults.", "tablets_white_round"],
        ["Loperamide", "Antidiarrheal", "Slows intestine movement.", "Acute and chronic diarrhea.", "Constipation, dizziness.", "Adults and children over 2.", "capsules_green_white_medical"],
        ["Albuterol", "Bronchodilator", "Asthma rescue inhaler.", "Asthma and COPD rescue.", "Tremor, palpitations.", "Adults and children.", "inhaler_medical_blue"],
        ["Montelukast", "Leukotriene Inhibitor", "Prevents asthma attacks.", "Chronic asthma, hay fever.", "Headache, stomach pain.", "Adults and children over 1.", "tablets_pink_round_small"],
        ["Cetirizine", "Antihistamine", "Second-generation antihistamine.", "Allergies, hay fever, hives.", "Drowsiness (minor), dry mouth.", "Adults and children over 2.", "tablets_white_round"],
        ["Loratadine", "Antihistamine", "Non-drowsy allergy relief.", "Sneezing, runny nose, watery eyes.", "Headache.", "Adults and children.", "tablets_white_round"],
        ["Sertraline", "Antidepressant", "SSRI antidepressant.", "Depression, panic attacks, OCD.", "Nausea, insomnia.", "Adults.", "tablets_white_round"],
        ["Gabapentin", "Anticonvulsant", "Nerve pain medication.", "Seizures, shingles pain.", "Dizziness, drowsiness.", "Adults and children.", "capsules_blue_white"],
        ["Alprazolam", "Anxiolytic", "Benzodiazepine for anxiety.", "Anxiety and panic disorders.", "Drowsiness, lightheadedness.", "Adults.", "tablets_white_round"],
        ["Metformin", "Antidiabetic", "Treatment for Type 2 diabetes.", "Blood sugar control, PCOS.", "Nausea, diarrhea.", "Adults and children over 10.", "tablets_large_oblong_white"],
        ["Levothyroxine", "Thyroid Hormone", "Thyroid replacement.", "Hypothyroidism.", "Insomnia (if dose high).", "All ages.", "tablets_white_round"],
        ["Tramadol", "Analgesic", "Opioid pain medication.", "Moderate to severe pain.", "Nausea, dizziness.", "Adults.", "capsules_green_white_medical"],
        ["Morphine", "Analgesic", "Powerful opioid.", "Severe acute or chronic pain.", "Drowsiness, constipation.", "Hospitalized patients.", "glass_vial_injection"],
        ["Codeine", "Analgesic", "Opioid for pain and cough.", "Mild pain, persistent cough.", "Drowsiness.", "Adults.", "syrup_glass_bottle_measuring_cup"],
        ["Levofloxacin", "Antibiotic", "Quinolone antibiotic.", "Pneumonia, kidney infections.", "Nausea, diarrhea.", "Adults.", "tablets_large_oblong_white"],
        ["Metronidazole", "Antibiotic", "Antibiotic and antiprotozoal.", "Vaginal infections, stomach infections.", "Metallic taste, nausea.", "Adults.", "tablets_white_round"],
        ["Nitrofurantoin", "Antibiotic", "Specific for UTIs.", "Treatment of UTIs.", "Nausea, dark urine.", "Adults.", "capsules_yellow_oval"],
        ["Penicillin V", "Antibiotic", "Historic antibiotic.", "Strep throat, rheumatic fever.", "Nausea, diarrhea.", "Patients with infections.", "tablets_white_round"],
        ["Simvastatin", "Statin", "Cholesterol-lowering.", "High cholesterol.", "Muscle pain.", "Adults.", "tablets_pink_round_small"],
        ["Rosuvastatin", "Statin", "Potent cholesterol reducer.", "Hyperlipidemia.", "Muscle ache.", "Adults.", "tablets_yellow_oval"],
        ["Valsartan", "ARB", "Angiotensin blocker.", "Hypertension.", "Dizziness.", "Adults.", "tablets_white_round"],
        ["Carvedilol", "Beta-Blocker", "Dual-action heart med.", "Heart failure, high BP.", "Dizziness, fatigue.", "Adults.", "tablets_white_round"],
        ["Spironolactone", "Diuretic", "Potassium-sparing.", "Edema, high BP.", "Increased potassium.", "Adults.", "tablets_white_round"],
        ["Warfarin", "Anticoagulant", "Blood thinner.", "Stroke prevention, DVT.", "Bleeding, bruising.", "High-risk patients.", "tablets_pink_round_small"],
        ["Clopidogrel", "Antiplatelet", "Prevents platelets sticking.", "Heart attack prevention.", "Bleeding.", "Post-heart attack patients.", "tablets_pink_round_small"],
        ["Rivaroxaban", "Anticoagulant", "Factor Xa inhibitor.", "DVT prevention.", "Bleeding.", "Adults.", "tablets_pink_round_small"],
        ["Glipizide", "Antidiabetic", "Stimulates insulin.", "Type 2 diabetes.", "Low sugar, nausea.", "Type 2 diabetics.", "tablets_white_round"],
        ["Januvia", "Antidiabetic", "DPP-4 inhibitor.", "Type 2 diabetes.", "Stuffy nose, headache.", "Type 2 diabetics.", "tablets_pink_round_small"],
        ["Jardiance", "Antidiabetic", "Removes sugar via urine.", "Type 2 diabetes.", "UTI, yeast infections.", "Type 2 diabetics.", "tablets_yellow_oval"],
        ["Victoza", "Antidiabetic", "Injectable GLP-1.", "Blood sugar control.", "Nausea, vomiting.", "Adults and children over 10.", "glass_vial_injection"],
        ["Fluticasone", "Corticosteroid", "Inhaler for inflammation.", "Asthma prevention.", "Sore throat, cough.", "Adults and children.", "inhaler_medical_blue"],
        ["Fexofenadine", "Antihistamine", "Non-drowsy allergy relief.", "Hay fever, seasonal allergies.", "Dizziness.", "Adults and children.", "tablets_white_round"],
        ["Diphenhydramine", "Antihistamine", "Sedating antihistamine.", "Allergies, sleep aid.", "Drowsiness, dry mouth.", "Adults.", "capsules_blue_white"],
        ["Ondansetron", "Antiemetic", "Prevents nausea.", "Chemo-induced nausea.", "Headache, constipation.", "Adults.", "tablets_white_round"],
        ["MiraLAX", "Laxative", "Osmotic laxative.", "Occasional constipation.", "Nausea, gas.", "Adults.", "bottle_white_sealed"],
        ["Escitalopram", "Antidepressant", "Anxiety and depression.", "ADHD, GAD.", "Nausea, sweating.", "Adults.", "tablets_white_round"],
        ["Fluoxetine", "Antidepressant", "SSRI antidepressant.", "Depression, panic disorder.", "Anxiety, insomnia.", "Adults.", "capsules_green_white_medical"],
        ["Diazepam", "Anxiolytic", "Fast-acting benzo.", "Anxiety, muscle spasms.", "Drowsiness, weakness.", "Adults.", "tablets_white_round"],
        ["Pregabalin", "Anticonvulsant", "Nerve pain medication.", "Fibromyalgia, seizures.", "Dizziness, sleepiness.", "Adults.", "capsules_blue_white"],
        ["Quetiapine", "Antipsychotic", "Atypical antipsychotic.", "Bipolar disorder.", "Weight gain, dry mouth.", "Adults.", "tablets_pink_round_small"],
        ["Lithium", "Mood Stabilizer", "For manic episodes.", "Bipolar disorder.", "Hand tremors, thirst.", "Adults.", "capsules_blue_white"],
        ["Oseltamivir", "Antiviral", "Prevents viral spread.", "Influenza A and B.", "Nausea, headache.", "Adults.", "capsules_yellow_oval"],
        ["Fluconazole", "Antifungal", "Azole antifungal.", "Yeast infections.", "Headache, nausea.", "Adults.", "tablets_pink_round_small"],
        ["Vitamin D3", "Nutritional", "Bone health.", "Deficiency, osteoporosis.", "Rare side effects.", "Everyone.", "bottle_amber_cap"],
        ["Folic Acid", "Nutritional", "Vitamin B9.", "Anemia, pregnancy.", "Gas (rare).", "Pregnant women.", "tablets_yellow_oval"],
        ["Sildenafil", "Hormonal", "PDE5 inhibitor.", "Erectile dysfunction.", "Flushing, headache.", "Adults.", "tablets_white_round"],
        ["Hydrocortisone", "Dermatological", "Steroid for skin.", "Rashes, eczema.", "Skin thinning.", "Adults.", "ointment_tube_medical_white"],
        ["Mupirocin", "Dermatological", "Antibiotic ointment.", "Skin infections.", "Burning, stinging.", "Adults.", "ointment_tube_medical_white"]
    ];

    foreach (range(count($medicinesData), 99) as $i) {
        $medicinesData[] = ["Generic Health Supplement $i", "General Health", "Supportive healthcare supplement.", "General maintenance.", "None reported.", "Adults.", "tablets_white_round"];
    }

    $stmt = $conn->prepare("INSERT INTO medicines (name, category, description, usefulness, side_effects, who_can_use, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($medicinesData as $med) {
        $med[6] = "assets/img/medicines/" . $med[6] . ".png";
        $stmt->execute($med);
    }

    // Re-enable foreign key checks
    $conn->exec("PRAGMA foreign_keys = ON");

    echo "Local database restored with your custom doctor list and images successfully.\n";
} catch (Exception $e) {
    echo "Restoration failed: " . $e->getMessage() . "\n";
}
