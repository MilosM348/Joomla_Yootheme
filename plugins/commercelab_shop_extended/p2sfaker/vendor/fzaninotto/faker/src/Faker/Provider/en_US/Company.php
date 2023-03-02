<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\en_US;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{lastName}}-{{lastName}}',
        '{{lastName}}, {{lastName}} and {{lastName}}',
    );

    protected static $catchPhraseWords = array(
        array(
            'Adaptive', 'Advanced', 'Ameliorated', 'Assimilated', 'Automated', 'Balanced', 'Business-focused', 'Centralized', 'Cloned', 'Compatible', 'Configurable', 'Cross-group', 'Cross-platform', 'Customer-focused', 'Customizable', 'Decentralized', 'De-engineered', 'Devolved', 'Digitized', 'Distributed', 'Diverse', 'Down-sized', 'Enhanced', 'Enterprise-wide', 'Ergonomic', 'Exclusive', 'Expanded', 'Extended', 'Facetoface', 'Focused', 'Front-line', 'Fully-configurable', 'Function-based', 'Fundamental', 'Future-proofed', 'Grass-roots', 'Horizontal', 'Implemented', 'Innovative', 'Integrated', 'Intuitive', 'Inverse', 'Managed', 'Mandatory', 'Monitored', 'Multi-channelled', 'Multi-lateral', 'Multi-layered', 'Multi-tiered', 'Networked', 'Object-based', 'Open-architected', 'Open-source', 'Operative', 'Optimized', 'Optional', 'Organic', 'Organized', 'Persevering', 'Persistent', 'Phased', 'Polarised', 'Pre-emptive', 'Proactive', 'Profit-focused', 'Profound', 'Programmable', 'Progressive', 'Public-key', 'Quality-focused', 'Reactive', 'Realigned', 'Re-contextualized', 'Re-engineered', 'Reduced', 'Reverse-engineered', 'Right-sized', 'Robust', 'Seamless', 'Secured', 'Self-enabling', 'Sharable', 'Stand-alone', 'Streamlined', 'Switchable', 'Synchronised', 'Synergistic', 'Synergized', 'Team-oriented', 'Total', 'Triple-buffered', 'Universal', 'Up-sized', 'Upgradable', 'User-centric', 'User-friendly', 'Versatile', 'Virtual', 'Visionary', 'Vision-oriented',
        ),
        array(
            '24hour', '24/7', '3rdgeneration', '4thgeneration', '5thgeneration', '6thgeneration', 'actuating', 'analyzing', 'assymetric', 'asynchronous', 'attitude-oriented', 'background', 'bandwidth-monitored', 'bi-directional', 'bifurcated', 'bottom-line', 'clear-thinking', 'client-driven', 'client-server', 'coherent', 'cohesive', 'composite', 'context-sensitive', 'contextually-based', 'content-based', 'dedicated', 'demand-driven', 'didactic', 'directional', 'discrete', 'disintermediate', 'dynamic', 'eco-centric', 'empowering', 'encompassing', 'even-keeled', 'executive', 'explicit', 'exuding', 'fault-tolerant', 'foreground', 'fresh-thinking', 'full-range', 'global', 'grid-enabled', 'heuristic', 'high-level', 'holistic', 'homogeneous', 'human-resource', 'hybrid', 'impactful', 'incremental', 'intangible', 'interactive', 'intermediate', 'leadingedge', 'local', 'logistical', 'maximized', 'methodical', 'mission-critical', 'mobile', 'modular', 'motivating', 'multimedia', 'multi-state', 'multi-tasking', 'national', 'needs-based', 'neutral', 'nextgeneration', 'non-volatile', 'object-oriented', 'optimal', 'optimizing', 'radical', 'real-time', 'reciprocal', 'regional', 'responsive', 'scalable', 'secondary', 'solution-oriented', 'stable', 'static', 'systematic', 'systemic', 'system-worthy', 'tangible', 'tertiary', 'transitional', 'uniform', 'upward-trending', 'user-facing', 'value-added', 'web-enabled', 'well-modulated', 'zeroadministration', 'zerodefect', 'zerotolerance',
        ),
        array(
            'ability', 'access', 'adapter', 'algorithm', 'alliance', 'analyzer', 'application', 'approach', 'architecture', 'archive', 'artificialintelligence', 'array', 'attitude', 'benchmark', 'blockchain', 'budgetarymanagement', 'capability', 'capacity', 'challenge', 'circuit', 'collaboration', 'complexity', 'concept', 'conglomeration', 'contingency', 'core', 'customerloyalty', 'database', 'data-warehouse', 'definition', 'emulation', 'encoding', 'encryption', 'extranet', 'firmware', 'flexibility', 'focusgroup', 'forecast', 'frame', 'framework', 'function', 'functionalities', 'GraphicInterface', 'groupware', 'GraphicalUserInterface', 'hardware', 'help-desk', 'hierarchy', 'hub', 'implementation', 'info-mediaries', 'infrastructure', 'initiative', 'installation', 'instructionset', 'interface', 'internetsolution', 'intranet', 'knowledgeuser', 'knowledgebase', 'localareanetwork', 'leverage', 'matrices', 'matrix', 'methodology', 'middleware', 'migration', 'model', 'moderator', 'monitoring', 'moratorium', 'neural-net', 'openarchitecture', 'opensystem', 'orchestration', 'paradigm', 'parallelism', 'policy', 'portal', 'pricingstructure', 'processimprovement', 'product', 'productivity', 'project', 'projection', 'protocol', 'securedline', 'service-desk', 'software', 'solution', 'standardization', 'strategy', 'structure', 'success', 'superstructure', 'support', 'synergy', 'systemengine', 'task-force', 'throughput', 'time-frame', 'toolset', 'utilisation', 'website', 'workforce',
        ),
    );

    protected static $bsWords = array(
        array(
            'implement', 'utilize', 'integrate', 'streamline', 'optimize', 'evolve', 'transform', 'embrace', 'enable', 'orchestrate', 'leverage', 'reinvent', 'aggregate', 'architect', 'enhance', 'incentivize', 'morph', 'empower', 'envisioneer', 'monetize', 'harness', 'facilitate', 'seize', 'disintermediate', 'synergize', 'strategize', 'deploy', 'brand', 'grow', 'target', 'syndicate', 'synthesize', 'deliver', 'mesh', 'incubate', 'engage', 'maximize', 'benchmark', 'expedite', 'reintermediate', 'whiteboard', 'visualize', 'repurpose', 'innovate', 'scale', 'unleash', 'drive', 'extend', 'engineer', 'revolutionize', 'generate', 'exploit', 'transition', 'e-enable', 'iterate', 'cultivate', 'matrix', 'productize', 'redefine', 'recontextualize',
        ),
        array(
            'clicks-and-mortar', 'value-added', 'vertical', 'proactive', 'robust', 'revolutionary', 'scalable', 'leading-edge', 'innovative', 'intuitive', 'strategic', 'e-business', 'mission-critical', 'sticky', 'one-to-one', '24/7', 'end-to-end', 'global', 'B2B', 'B2C', 'granular', 'frictionless', 'virtual', 'viral', 'dynamic', '24/365', 'best-of-breed', 'killer', 'magnetic', 'bleeding-edge', 'web-enabled', 'interactive', 'dot-com', 'sexy', 'back-end', 'real-time', 'efficient', 'front-end', 'distributed', 'seamless', 'extensible', 'turn-key', 'world-class', 'open-source', 'cross-platform', 'cross-media', 'synergistic', 'bricks-and-clicks', 'out-of-the-box', 'enterprise', 'integrated', 'impactful', 'wireless', 'transparent', 'next-generation', 'cutting-edge', 'user-centric', 'visionary', 'customized', 'ubiquitous', 'plug-and-play', 'collaborative', 'compelling', 'holistic', 'rich',
        ),
        array(
            'synergies', 'web-readiness', 'paradigms', 'markets', 'partnerships', 'infrastructures', 'platforms', 'initiatives', 'channels', 'eyeballs', 'communities', 'ROI', 'solutions', 'e-tailers', 'e-services', 'action-items', 'portals', 'niches', 'technologies', 'content', 'vortals', 'supply-chains', 'convergence', 'relationships', 'architectures', 'interfaces', 'e-markets', 'e-commerce', 'systems', 'bandwidth', 'infomediaries', 'models', 'mindshare', 'deliverables', 'users', 'schemas', 'networks', 'applications', 'metrics', 'e-business', 'functionalities', 'experiences', 'webservices', 'methodologies',
        ),
    );

    /**
     * Source - http://www.careerplanner.com/ListOfJobs.cfm
     */
    protected static $jobTitleFormat = array(
        'Able Seamen', 'Account Manager', 'Accountant', 'Actor', 'Actuary', 'Adjustment Clerk', 'Admin', 'Administrative Law Judge', 'Administrative Services Manager', 'Administrative Support Supervisors', 'Advertising Manager OR Promotions Manager', 'Advertising Sales Agent', 'Aerospace Engineer', 'Agricultural Crop Farm Manager', 'Agricultural Crop Worker', 'Agricultural Engineer', 'Agricultural Equipment Operator', 'Agricultural Inspector', 'Agricultural Manager', 'Agricultural Product Grader Sorter', 'Agricultural Sales Representative', 'Agricultural Science Technician', 'Agricultural Sciences Teacher', 'Agricultural Technician', 'Agricultural Worker', 'Air Crew Member', 'Air Crew Officer', 'Air Traffic Controller', 'Aircraft Assembler', 'Aircraft Body Repairer', 'Aircraft Cargo Handling Supervisor', 'Aircraft Engine Specialist', 'Aircraft Launch and Recovery Officer', 'Aircraft Launch Specialist', 'Aircraft Mechanics OR Aircraft Service Technician', 'Aircraft Rigging Assembler', 'Aircraft Structure Assemblers', 'Airfield Operations Specialist', 'Airframe Mechanic', 'Airline Pilot OR Copilot OR Flight Engineer', 'Algorithm Developer', 'Alteration Tailor', 'Ambulance Driver', 'Amusement Attendant', 'Anesthesiologist', 'Animal Breeder', 'Animal Care Workers', 'Animal Control Worker', 'Animal Husbandry Worker', 'Animal Scientist', 'Animal Trainer', 'Annealing Machine Operator', 'Announcer', 'Answering Service', 'Anthropologist', 'Anthropologist OR Archeologist', 'Anthropology Teacher', 'Appliance Repairer', 'Arbitrator', 'Archeologist', 'Architect', 'Architectural Drafter', 'Architectural Drafter OR Civil Drafter', 'Architecture Teacher', 'Archivist', 'Armored Assault Vehicle Crew Member', 'Armored Assault Vehicle Officer', 'Art Director', 'Art Teacher', 'Artillery Officer', 'Artillery Crew Member', 'Artist', 'Assembler', 'Assessor', 'Astronomer', 'Athletes and Sports Competitor', 'Athletic Trainer', 'Atmospheric and Space Scientist', 'Audio and Video Equipment Technician', 'Audiologist', 'Audio-Visual Collections Specialist', 'Auditor', 'Auditor', 'Automatic Teller Machine Servicer', 'Automotive Body Repairer', 'Automotive Glass Installers', 'Automotive Master Mechanic', 'Automotive Mechanic', 'Automotive Specialty Technician', 'Automotive Technician', 'Auxiliary Equipment Operator', 'Aviation Inspector', 'Avionics Technician',
        'Bailiff', 'Baker', 'Barber', 'Bartender', 'Bartender Helper', 'Battery Repairer', 'Bellhop', 'Bench Jeweler', 'Benefits Specialist', 'Bicycle Repairer', 'Bill and Account Collector', 'Bindery Machine Operator', 'Bindery Worker', 'Biochemist', 'Biochemist or Biophysicist', 'Biological Science Teacher', 'Biological Scientist', 'Biological Technician', 'Biologist', 'Biomedical Engineer', 'Biophysicist', 'Board Of Directors', 'Boat Builder and Shipwright', 'Boiler Operator', 'Boilermaker', 'Bookbinder', 'Bookkeeper', 'Brake Machine Setter', 'Brattice Builder', 'Brazer', 'Brazing Machine Operator', 'Brickmason', 'Bridge Tender OR Lock Tender', 'Broadcast News Analyst', 'Broadcast Technician', 'Brokerage Clerk', 'Budget Analyst', 'Buffing and Polishing Operator', 'Building Cleaning Worker', 'Building Inspector', 'Bulldozer Operator', 'Bus Driver', 'Business Development Manager', 'Business Manager', 'Business Operations Specialist', 'Business Teacher', 'Butcher', 'Buyer',
        'Cabinetmaker', 'Cafeteria Cook', 'Calibration Technician OR Instrumentation Technician', 'Camera Operator', 'Camera Repairer', 'Captain', 'Caption Writer', 'Cardiovascular Technologist', 'Career Counselor', 'Carpenter', 'Carpenter Assembler and Repairer', 'Carpet Installer', 'Cartographer', 'Cartoonist', 'Carver', 'Cashier', 'Casting Machine Operator', 'Casting Machine Set-Up Operator', 'ccc', 'Ceiling Tile Installer', 'Cement Mason and Concrete Finisher', 'Central Office', 'Central Office and PBX Installers', 'Central Office Operator', 'CEO', 'CFO', 'Chef', 'Chemical Engineer', 'Chemical Equipment Controller', 'Chemical Equipment Operator', 'Chemical Equipment Tender', 'Chemical Plant Operator', 'Chemical Technician', 'Chemist', 'Chemistry Teacher', 'Child Care', 'Child Care Worker', 'Chiropractor', 'Choreographer', 'City', 'City Planning Aide', 'Civil Drafter', 'Civil Engineer', 'Civil Engineering Technician', 'Claims Adjuster', 'Claims Examiner', 'Claims Taker', 'Cleaners of Vehicles', 'Clergy', 'Clerk', 'Clinical Laboratory Technician', 'Clinical Psychologist', 'Clinical School Psychologist', 'Coaches and Scout', 'Coating Machine Operator', 'Coil Winders', 'Command Control Center Officer', 'Command Control Center Specialist', 'Commercial and Industrial Designer', 'Commercial Diver', 'Commercial Pilot', 'Communication Equipment Repairer', 'Communication Equipment Worker', 'Communications Equipment Operator', 'Communications Teacher', 'Community Service Manager', 'Compacting Machine Operator', 'Compensation and Benefits Manager', 'Compliance Officers', 'Composer', 'Computer', 'Computer Hardware Engineer', 'Computer Operator', 'Computer Programmer', 'Computer Repairer', 'Computer Science Teacher', 'Computer Scientist', 'Computer Security Specialist', 'Computer Software Engineer', 'Computer Specialist', 'Computer Support Specialist', 'Computer Systems Analyst', 'Computer-Controlled Machine Tool Operator', 'Concierge', 'Conservation Scientist', 'Construction', 'Construction Carpenter', 'Construction Driller', 'Construction Equipment Operator', 'Construction Laborer', 'Construction Manager', 'Continuous Mining Machine Operator', 'Control Valve Installer', 'Conveyor Operator', 'Cook', 'Cooling and Freezing Equipment Operator', 'Copy Machine Operator', 'Copy Writer', 'Coremaking Machine Operator', 'Coroner', 'Corporate Trainer', 'Correctional Officer', 'Correspondence Clerk', 'Cost Estimator', 'Costume Attendant', 'Counseling Psychologist', 'Counselor', 'Counsil', 'Courier', 'Court Clerk', 'Court Reporter', 'Craft Artist', 'Crane and Tower Operator', 'Creative Writer', 'Credit Checkers Clerk', 'Credit Analyst', 'Credit Authorizer', 'Credit Checker', 'Criminal Investigator', 'Crossing Guard', 'Crushing Grinding Machine Operator', 'CSI', 'CTO', 'Cultural Studies Teacher', 'Curator', 'Custom Tailor', 'Customer Service Representative', 'Cutting Machine Operator', 'Cutting Machine Operator',
        'Dancer', 'Data Entry Operator', 'Data Processing Equipment Repairer', 'Database Administrator', 'Database Manager', 'Deburring Machine Operator', 'Decorator', 'Dental Assistant', 'Dental Hygienist', 'Dental Laboratory Technician', 'Dentist', 'Designer', 'Desktop Publisher', 'Detective', 'Diagnostic Medical Sonographer', 'Diamond Worker', 'Diesel Engine Specialist', 'Dietetic Technician', 'Director Of Business Development', 'Director Of Marketing', 'Director Of Social Media Marketing', 'Director Of Talent Acquisition', 'Director Religious Activities', 'Directory Assistance Operator', 'Dishwasher', 'Dispatcher', 'Distribution Manager', 'Door To Door Sales', 'Dot Etcher', 'Drafter', 'Dragline Operator', 'Dredge Operator', 'Drilling and Boring Machine Tool Setter', 'Driver-Sales Worker', 'Drycleaning Machine Operator', 'Drywall Ceiling Tile Installer', 'Drywall Installer',
        'Earth Driller', 'Economics Teacher', 'Economist', 'Editor', 'Education Administrator', 'Education Teacher', 'Educational Counselor OR Vocationall Counselor', 'Educational Psychologist', 'Electric Meter Installer', 'Electric Motor Repairer', 'Electrical and Electronic Inspector and Tester', 'Electrical and Electronics Drafter', 'Electrical Drafter', 'Electrical Engineer', 'Electrical Engineering Technician', 'Electrical Parts Reconditioner', 'Electrical Power-Line Installer', 'Electrical Sales Representative', 'Electrician', 'Electrician', 'Electrolytic Plating Machine Operator', 'Electromechanical Equipment Assembler', 'Electro-Mechanical Technician', 'Electronic Drafter', 'Electronic Engineering Technician', 'Electronic Equipment Assembler', 'Electronic Masking System Operator', 'Electronics Engineer', 'Electronics Engineering Technician', 'Electrotyper', 'Elementary and Secondary School Administrators', 'Elementary School Teacher', 'Elevator Installer and Repairer', 'Eligibility Interviewer', 'Embalmer', 'Embossing Machine Operator', 'Emergency Management Specialist', 'Emergency Medical Technician and Paramedic', 'Employment Interviewer', 'Engine Assembler', 'Engineer', 'Engineering', 'Engineering Manager', 'Engineering Teacher', 'Engineering Technician', 'English Language Teacher', 'Engraver', 'Entertainer and Performer', 'Entertainment Attendant', 'Environmental Compliance Inspector', 'Environmental Engineer', 'Environmental Engineering Technician', 'Environmental Science Teacher', 'Environmental Science Technician', 'Environmental Scientist', 'Epidemiologist', 'Equal Opportunity Representative', 'Etcher', 'Etcher and Engraver', 'Event Planner', 'Excavating Machine Operator', 'Executive Secretary', 'Exhibit Designer', 'Explosives Expert', 'Extraction Worker', 'Extruding and Drawing Machine Operator', 'Extruding Machine Operator',
        'Fabric Mender', 'Fabric Pressers', 'Farm and Home Management Advisor', 'Farm Equipment Mechanic', 'Farm Labor Contractor', 'Farmer', 'Farmworker', 'Fashion Designer', 'Fashion Model', 'Fast Food Cook', 'Fence Erector', 'Fiber Product Cutting Machine Operator', 'Fiberglass Laminator and Fabricator', 'File Clerk', 'Film Laboratory Technician', 'Financial Analyst', 'Financial Examiner', 'Financial Manager', 'Financial Services Sales Agent', 'Financial Specialist', 'Fire Fighter', 'Fire Inspector', 'Fire Investigator', 'Fire-Prevention Engineer', 'First-Line Supervisor-Manager of Landscaping, Lawn Service, and Groundskeeping Worker', 'Fish Game Warden', 'Fish Hatchery Manager', 'Fishery Worker', 'Fishing OR Forestry Supervisor', 'Fitness Trainer', 'Fitter', 'Flight Attendant', 'Floor Finisher', 'Floor Layer', 'Floral Designer', 'Food Batchmaker', 'Food Cooking Machine Operators', 'Food Preparation', 'Food Preparation and Serving Worker', 'Food Preparation Worker', 'Food Science Technician', 'Food Scientists and Technologist', 'Food Servers', 'Food Service Manager', 'Food Tobacco Roasting', 'Foreign Language Teacher', 'Forensic Investigator', 'Forensic Science Technician', 'Forest and Conservation Technician', 'Forest and Conservation Worker', 'Forest Fire Fighter', 'Forest Fire Fighting Supervisor', 'Forest Fire Inspector', 'Forester', 'Forestry Conservation Science Teacher', 'Forging Machine Setter', 'Forming Machine Operator', 'Forming Machine Operator', 'Foundry Mold and Coremaker', 'Fraud Investigator', 'Freight Agent', 'Freight and Material Mover', 'Freight Inspector', 'Funeral Attendant', 'Funeral Director', 'Furnace Operator', 'Furniture Finisher',
        'Gaming Cage Worker', 'Gaming Dealer', 'Gaming Manager', 'Gaming Service Worker', 'Gaming Supervisor', 'Gaming Surveillance Officer', 'Garment', 'Gas Appliance Repairer', 'Gas Compressor Operator', 'Gas Distribution Plant Operator', 'Gas Plant Operator', 'Gas Processing Plant Operator', 'Gas Pumping Station Operator', 'Gas Pumping Station Operator', 'Gauger', 'GED Teacher', 'General Farmworker', 'General Manager', 'General Practitioner', 'Geographer', 'Geography Teacher', 'Geological Data Technician', 'Geological Sample Test Technician', 'Geologist', 'Geoscientists', 'Glass Blower', 'Glass Cutting Machine Operator', 'Glazier', 'Gluing Machine Operator', 'Government', 'Government Property Inspector', 'Government Service Executive', 'Graduate Teaching Assistant', 'Graphic Designer', 'Grinder OR Polisher', 'Grinding Machine Operator', 'Grips', 'Grounds Maintenance Worker',
        'Hairdresser OR Cosmetologist', 'Hand Trimmer', 'Hand Presser', 'Hand Sewer', 'Hazardous Materials Removal Worker', 'Head Nurse', 'Health Educator', 'Health Practitioner', 'Health Services Manager', 'Health Specialties Teacher', 'Health Technologist', 'Healthcare', 'Healthcare Practitioner', 'Healthcare Support Worker', 'Heat Treating Equipment Operator', 'Heaters', 'Heating and Air Conditioning Mechanic', 'Heating Equipment Operator', 'Heavy Equipment Mechanic', 'Highway Maintenance Worker', 'Highway Patrol Pilot', 'Historian', 'History Teacher', 'Hoist and Winch Operator', 'Home', 'Home Appliance Installer', 'Home Appliance Repairer', 'Home Economics Teacher', 'Home Entertainment Equipment Installer', 'Home Health Aide', 'Homeland Security', 'Horticultural Worker', 'Host and Hostess', 'Hotel Desk Clerk', 'House Cleaner', 'Housekeeper', 'Housekeeping Supervisor', 'HR Manager', 'HR Specialist', 'Human Resource Director', 'Human Resource Manager', 'Human Resources Assistant', 'Human Resources Manager', 'Human Resources Specialist', 'Hunter and Trapper', 'HVAC Mechanic', 'Hydrologist',
        'Illustrator', 'Immigration Inspector OR Customs Inspector', 'Industrial Engineer', 'Industrial Engineering Technician', 'Industrial Equipment Maintenance', 'Industrial Machinery Mechanic', 'Industrial Production Manager', 'Industrial Safety Engineer', 'Industrial-Organizational Psychologist', 'Infantry', 'Infantry Officer', 'Information Systems Manager', 'Inspector', 'Installation and Repair Technician', 'Instructional Coordinator', 'Instrument Sales Representative', 'Insulation Installer', 'Insulation Worker', 'Insurance Investigator', 'Insurance Appraiser', 'Insurance Claims Clerk', 'Insurance Policy Processing Clerk', 'Insurance Sales Agent', 'Insurance Underwriter', 'Interaction Designer', 'Interior Designer', 'Internist', 'Interpreter OR Translator', 'Interviewer', 'Irradiated-Fuel Handler',
        'Janitor', 'Janitorial Supervisor', 'Jeweler', 'Jewelry Model OR Mold Makers', 'Job Printer', 'Judge',
        'Keyboard Instrument Repairer and Tuner', 'Kindergarten Teacher',
        'Landscape Architect', 'Landscape Artist', 'Landscaper', 'Landscaping', 'Lathe Operator', 'Laundry OR Dry-Cleaning Worker', 'Law Clerk', 'Law Enforcement Teacher', 'Law Teacher', 'Lawn Service Manager', 'Lawyer', 'Lay-Out Worker', 'Legal Secretary', 'Legal Support Worker', 'Legislator', 'Letterpress Setters Operator', 'Librarian', 'Library Assistant', 'Library Science Teacher', 'Library Technician', 'Library Worker', 'License Clerk', 'Licensed Practical Nurse', 'Licensing Examiner and Inspector', 'Life Science Technician', 'Life Scientists', 'Lifeguard', 'Loading Machine Operator', 'Loan Counselor', 'Loan Interviewer', 'Loan Officer', 'Locker Room Attendant', 'Locksmith', 'Locomotive Engineer', 'Locomotive Firer', 'Lodging Manager', 'Log Grader and Scaler', 'Logging Equipment Operator', 'Logging Supervisor', 'Logging Tractor Operator', 'Logging Worker', 'Logistician',
        'Machine Feeder', 'Machine Operator', 'Machine Tool Operator', 'Machinery Maintenance', 'Machinist', 'Maid', 'Mail Clerk', 'Mail Machine Operator', 'Maintenance and Repair Worker', 'Maintenance Equipment Operator', 'Maintenance Supervisor', 'Maintenance Worker', 'Makeup Artists', 'Management Analyst', 'Manager', 'Manager of Air Crew', 'Manager of Food Preparation', 'Manager of Weapons Specialists', 'Manager Tactical Operations', 'Manicurists', 'Manufactured Building Installer', 'Manufacturing Sales Representative', 'Mapping Technician', 'MARCOM Director', 'MARCOM Manager', 'Marine Architect', 'Marine Cargo Inspector', 'Marine Engineer', 'Marine Oiler', 'Market Research Analyst', 'Marketing Manager', 'Marketing VP', 'Marking Clerk', 'Marking Machine Operator', 'Marriage and Family Therapist', 'Massage Therapist', 'Material Movers', 'Material Moving Worker', 'Materials Engineer', 'Materials Inspector', 'Materials Scientist', 'Mathematical Science Teacher', 'Mathematical Scientist', 'Mathematical Technician', 'Mathematician', 'Meat Packer', 'Mechanical Door Repairer', 'Mechanical Drafter', 'Mechanical Engineer', 'Mechanical Engineering Technician', 'Mechanical Equipment Sales Representative', 'Mechanical Inspector', 'Media and Communication Worker', 'Medical Appliance Technician', 'Medical Assistant', 'Medical Equipment Preparer', 'Medical Equipment Repairer', 'Medical Laboratory Technologist', 'Medical Records Technician', 'Medical Sales Representative', 'Medical Scientists', 'Medical Secretary', 'Medical Technician', 'Medical Transcriptionist', 'Mental Health Counselor', 'Merchandise Displayer OR Window Trimmer', 'Metal Fabricator', 'Metal Molding Operator', 'Metal Pourer and Caster', 'Metal Worker', 'Metal-Refining Furnace Operator', 'Meter Mechanic', 'Microbiologist', 'Middle School Teacher', 'Military Officer', 'Milling Machine Operator', 'Millwright', 'Mine Cutting Machine Operator', 'Mining Engineer OR Geological Engineer', 'Mining Machine Operator', 'Mixing and Blending Machine Operator', 'Model Maker', 'Mold Maker', 'Molder', 'Molding and Casting Worker', 'Molding Machine Operator', 'Motion Picture Projectionist', 'Motor Vehicle Inspector', 'Motor Vehicle Operator', 'Motorboat Mechanic', 'Motorboat Operator', 'Motorcycle Mechanic', 'Movers', 'Movie Director oR Theatre Director', 'Multi-Media Artist', 'Multiple Machine Tool Setter', 'Municipal Clerk', 'Municipal Court Clerk', 'Municipal Fire Fighter', 'Municipal Fire Fighting Supervisor', 'Museum Conservator', 'Music Arranger and Orchestrator', 'Music Composer', 'Music Director', 'Musical Instrument Tuner', 'Musician', 'Musician OR Singer',
        'Natural Sciences Manager', 'Naval Architects', 'Network Admin OR Computer Systems Administrator', 'Network Systems Analyst', 'New Accounts Clerk', 'Night Security Guard', 'Night Shift', 'Nonfarm Animal Caretaker', 'Nuclear Engineer', 'Nuclear Equipment Operation Technician', 'Nuclear Medicine Technologist', 'Nuclear Monitoring Technician', 'Nuclear Power Reactor Operator', 'Nuclear Technician', 'Numerical Control Machine Tool Operator', 'Numerical Tool Programmer OR Process Control Programmer', 'Nursery Manager', 'Nursery Worker', 'Nursing Aide', 'Nursing Instructor', 'Nutritionist',
        'Obstetrician', 'Occupational Health Safety Specialist', 'Occupational Health Safety Technician', 'Occupational Therapist', 'Occupational Therapist Aide', 'Occupational Therapist Assistant', 'Office and Administrative Support Worker', 'Office Clerk', 'Office Machine and Cash Register Servicer', 'Office Machine Operator', 'Offset Lithographic Press Operator', 'Oil and gas Operator', 'Oil Service Unit Operator', 'Online Marketing Analyst', 'Operating Engineer', 'Operations Research Analyst', 'Ophthalmic Laboratory Technician', 'Optical Instrument Assembler', 'Opticians', 'Optometrist', 'Oral Surgeon', 'Order Clerk', 'Order Filler', 'Order Filler OR Stock Clerk', 'Organizational Development Manager', 'Orthodontist', 'Orthotist OR Prosthetist', 'Outdoor Power Equipment Mechanic',
        'Packaging Machine Operator', 'Packer and Packager', 'Painter', 'Painter and Illustrator', 'Painting Machine Operator', 'Pantograph Engraver', 'Paper Goods Machine Operator', 'Paperhanger', 'Paralegal', 'Park Naturalist', 'Parking Enforcement Worker', 'Parking Lot Attendant', 'Parts Salesperson', 'Paste-Up Worker', 'Pastry Chef', 'Patrol Officer', 'Patternmaker', 'Paving Equipment Operator', 'Payroll Clerk', 'Pediatricians', 'Percussion Instrument Repairer', 'Personal Care Worker', 'Personal Financial Advisor', 'Personal Home Care Aide', 'Personal Service Worker', 'Personal Trainer', 'Personnel Recruiter', 'Pest Control Worker', 'Pesticide Sprayer', 'Petroleum Engineer', 'Petroleum Pump Operator', 'Petroleum Pump System Operator', 'Petroleum Technician', 'Pewter Caster', 'Pharmaceutical Sales Representative', 'Pharmacist', 'Pharmacy Aide', 'Pharmacy Technician', 'Philosophy and Religion Teacher', 'Photoengraver', 'Photoengraving Machine Operator', 'Photographer', 'Photographic Restorer', 'Photographic Developer', 'Photographic Process Worker', 'Photographic Processing Machine Operator', 'Photographic Reproduction Technician', 'Physical Scientist', 'Physical Therapist', 'Physical Therapist Aide', 'Physical Therapist Assistant', 'Physician', 'Physician Assistant', 'Physicist', 'Physics Teacher', 'Pile-Driver Operator', 'Pipe Fitter', 'Pipefitter', 'Pipelayer', 'Pipelaying Fitter', 'Plant and System Operator', 'Plant Scientist', 'Plasterer OR Stucco Mason', 'Plastic Molding Machine Operator', 'Plate Finisher', 'Platemaker', 'Plating Machine Operator', 'Plating Operator', 'Plating Operator OR Coating Machine Operator', 'Plumber', 'Plumber OR Pipefitter OR Steamfitter', 'Podiatrist', 'Poet OR Lyricist', 'Police and Sheriffs Patrol Officer', 'Police Detective', 'Police Identification OR Records Officer', 'Political Science Teacher', 'Political Scientist', 'Portable Power Tool Repairer', 'Postal Clerk', 'Postal Service Clerk', 'Postal Service Mail Carrier', 'Postal Service Mail Sorter', 'Postmasters', 'Postsecondary Education Administrators', 'Postsecondary Teacher', 'Potter', 'Poultry Cutter', 'Power Distributors OR Dispatcher', 'Power Generating Plant Operator', 'Power Plant Operator', 'PR Manager', 'Precious Stone Worker', 'Precision Aircraft Systems Assemblers', 'Precision Devices Inspector', 'Precision Dyer', 'Precision Etcher and Engraver', 'Precision Instrument Repairer', 'Precision Lens Grinders and Polisher', 'Precision Mold and Pattern Caster', 'Precision Pattern and Die Caster', 'Precision Printing Worker', 'Prepress Technician', 'Preschool Education Administrators', 'Preschool Teacher', 'Press Machine Setter, Operator', 'Pressing Machine Operator', 'Pressure Vessel Inspector', 'Printing Machine Operator', 'Printing Press Machine Operator', 'Private Detective and Investigator', 'Private Household Cook', 'Private Sector Executive', 'Probation Officers and Correctional Treatment Specialist', 'Procurement Clerk', 'Producer', 'Producers and Director', 'Product Management Leader', 'Product Promoter', 'Product Safety Engineer', 'Product Specialist', 'Production Control Manager', 'Production Helper', 'Production Inspector', 'Production Laborer', 'Production Manager', 'Production Planner', 'Production Planning', 'Production Worker', 'Professional Photographer', 'Professor', 'Program Director', 'Project Manager', 'Proofreaders and Copy Marker', 'Prosthodontist', 'Protective Service Worker', 'Protective Service Worker', 'Psychiatric Aide', 'Psychiatric Technician', 'Psychiatrist', 'Psychologist', 'Psychology Teacher', 'Public Health Social Worker', 'Public Relations Manager', 'Public Relations Specialist', 'Public Transportation Inspector', 'Pump Operators', 'Punching Machine Setters', 'Purchasing Agent', 'Purchasing Manager',
        'Radar Technician', 'Radiation Therapist', 'Radio and Television Announcer', 'Radio Mechanic', 'Radio Operator', 'Radiologic Technician', 'Radiologic Technologist', 'Radiologic Technologist and Technician', 'Rail Car Repairer', 'Rail Transportation Worker', 'Rail Yard Engineer', 'Railroad Conductors', 'Railroad Inspector', 'Railroad Switch Operator', 'Railroad Yard Worker', 'Range Manager', 'Real Estate Appraiser', 'Real Estate Association Manager', 'Real Estate Broker', 'Real Estate Sales Agent', 'Receptionist and Information Clerk', 'Record Clerk', 'Recordkeeping Clerk', 'Recreation and Fitness Studies Teacher', 'Recreation Worker', 'Recreational Therapist', 'Recreational Vehicle Service Technician', 'Recruiter', 'Recyclable Material Collector', 'Refinery Operator', 'Refractory Materials Repairer', 'Refrigeration Mechanic', 'Registered Nurse', 'Rehabilitation Counselor', 'Religious Worker', 'Rental Clerk', 'Reporters OR Correspondent', 'Reservation Agent OR Transportation Ticket Agent', 'Residential Advisor', 'Respiratory Therapist', 'Respiratory Therapy Technician', 'Restaurant Cook', 'Retail Sales person', 'Retail Salesperson', 'Rigger', 'RN', 'Rock Splitter', 'Rolling Machine Setter', 'Roof Bolters Mining', 'Roofer', 'Rotary Drill Operator', 'Rough Carpenter', 'Roustabouts',
        'Safety Engineer', 'Sailor', 'Sales and Related Workers', 'Sales Engineer', 'Sales Manager', 'Sales Person', 'Sales Representative', 'Sawing Machine Operator', 'Sawing Machine Setter', 'Sawing Machine Tool Setter', 'Scanner Operator', 'School Bus Driver', 'School Social Worker', 'Scientific Photographer', 'Screen Printing Machine Operator', 'Sculptor', 'Secondary School Teacher', 'Secretary', 'Securities Sales Agent', 'Security Guard', 'Security Systems Installer OR Fire Alarm Systems Installer', 'Segmental Paver', 'Self-Enrichment Education Teacher', 'Semiconductor Processor', 'Separating Machine Operators', 'Septic Tank Servicer', 'Service Station Attendant', 'Set and Exhibit Designer', 'Set Designer', 'Sewing Machine Operator', 'Shampooer', 'Shear Machine Set-Up Operator', 'Sheet Metal Worker', 'Sheriff', 'Ship Captain', 'Ship Carpenter and Joiner', 'Ship Engineer', 'Ship Mates', 'Ship Pilot', 'Shipping and Receiving Clerk', 'Shoe and Leather Repairer', 'Shoe Machine Operators', 'Short Order Cook', 'Shuttle Car Operator', 'Signal Repairer OR Track Switch Repairer', 'Silversmith', 'Singer', 'Sketch Artist', 'Skin Care Specialist', 'Slot Key Person', 'Social and Human Service Assistant', 'Social Media Marketing Manager', 'Social Science Research Assistant', 'Social Sciences Teacher', 'Social Scientists', 'Social Service Specialists', 'Social Work Teacher', 'Social Worker', 'Sociologist', 'Sociology Teacher', 'Software Engineer', 'Soil Conservationist', 'Soil Scientist', 'Soil Scientist OR Plant Scientist', 'Solderer', 'Soldering Machine Setter', 'Sound Engineering Technician', 'Space Sciences Teacher', 'Special Education Teacher', 'Special Force', 'Special Forces Officer', 'Speech-Language Pathologist', 'Sports Book Writer', 'Spotters', 'Spraying Machine Operator', 'Staff Psychologist', 'State', 'Statement Clerk', 'Stationary Engineer', 'Stationary Engineer OR Boiler Operator', 'Statistical Assistant', 'Statistician', 'Steel Worker', 'Stevedore', 'Stock Broker', 'Stock Clerk', 'Stone Cutter', 'Stone Sawyer', 'Stonemason', 'Stonemason', 'Storage Manager OR Distribution Manager', 'Streetcar Operator', 'Stringed Instrument Repairer and Tuner', 'Structural Iron and Steel Worker', 'Structural Metal Fabricator', 'Substance Abuse Counselor', 'Substance Abuse Social Worker', 'Substation Maintenance', 'Supervisor Correctional Officer', 'Supervisor Fire Fighting Worker', 'Supervisor of Customer Service', 'Supervisor of Police', 'Surgeon', 'Surgical Technologist', 'Survey Researcher', 'Surveying and Mapping Technician', 'Surveying Technician', 'Surveyor', 'Sys Admin', 'System Administrator',
        'Tailor', 'Talent Acquisition Manager', 'Talent Director', 'Tank Car', 'Taper', 'Tax Examiner', 'Tax Preparer', 'Taxi Drivers and Chauffeur', 'Teacher', 'Teacher Assistant', 'Team Assembler', 'Technical Director', 'Technical Program Manager', 'Technical Specialist', 'Technical Writer', 'Telecommunications Equipment Installer', 'Telecommunications Facility Examiner', 'Telecommunications Line Installer', 'Telemarketer', 'Telephone Operator', 'Telephone Station Installer and Repairer', 'Teller', 'Terrazzo Workes and Finisher', 'Textile Cutting Machine Operator', 'Textile Dyeing Machine Operator', 'Textile Knitting Machine Operator', 'Textile Machine Operator', 'Textile Worker', 'Therapist', 'Ticket Agent', 'Tile Setter OR Marble Setter', 'Timing Device Assemblers', 'Tire Builder', 'Tire Changer', 'Title Abstractor', 'Title Examiner', 'Title Searcher', 'Tool and Die Maker', 'Tool Set-Up Operator', 'Tool Sharpener', 'Tour Guide', 'Tractor Operator', 'Tractor-Trailer Truck Driver', 'Traffic Technician', 'Train Crew', 'Trainer', 'Training Manager OR Development Manager', 'Transformer Repairer', 'Transit Police OR Railroad Police', 'Transportation and Material-Moving', 'Transportation Attendant', 'Transportation Equipment Maintenance', 'Transportation Equipment Painters', 'Transportation Inspector', 'Transportation Manager', 'Transportation Worker', 'Travel Agent', 'Travel Clerk', 'Travel Guide', 'Tree Trimmer', 'Truck Driver', 'TSA', 'Typesetter', 'Typesetting Machine Operator',
        'Umpire and Referee', 'Underground Mining', 'University', 'Upholsterer', 'Urban Planner', 'User Experience Manager', 'User Experience Researcher', 'Usher', 'Utility Meter Reader',
        'Valve Repairer OR Regulator Repairer', 'Vending Machine Servicer', 'Veterinarian', 'Veterinary Assistant OR Laboratory Animal Caretaker', 'Veterinary Technician', 'Vice President Of Human Resources', 'Vice President Of Marketing', 'Video Editor', 'Visual Designer', 'Vocational Education Teacher',
        'Waiter', 'Waitress', 'Warehouse', 'Washing Equipment Operator', 'Waste Treatment Plant Operator', 'Watch Repairer', 'Weapons Specialists', 'Web Developer', 'Webmaster', 'Welder', 'Welder', 'Welder and Cutter', 'Welder-Fitter', 'Welding Machine Tender', 'Welding Machine Operator', 'Welding Machine Setter', 'Welfare Eligibility Clerk', 'Well and Core Drill Operator', 'Wellhead Pumper', 'Wholesale Buyer', 'Wind Instrument Repairer', 'Woodworker', 'Woodworking Machine Operator', 'Woodworking Machine Setter', 'Word Processors and Typist', 'Writer OR Author',
        'Zoologists OR Wildlife Biologist',
    );

    protected static $companySuffix = array('Inc', 'and Sons', 'LLC', 'Group', 'PLC', 'Ltd');

    /**
     * @link https://www.irs.gov/businesses/small-businesses-self-employed/how-eins-are-assigned-and-valid-ein-prefixes
     */
    protected static $einPrefixes = array(
        01, 02, 03, 04, 05, 06, 10, 11, 12, 13, 14, 15, 16, 20, 21, 22, 23, 24, 25, 26, 27, 30, 31, 32, 33, 34, 35, 36,
        37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65,
        66, 67, 68, 71, 72, 73, 74, 75, 76, 77, 80, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 94, 95, 98, 99
    );

    /**
     * @example 'Robust full-range hub'
     */
    public function catchPhrase()
    {
        $result = array();
        foreach (static::$catchPhraseWords as &$word) {
            $result[] = static::randomElement($word);
        }

        return join(' ', $result);
    }

    /**
     * @example 'integrate extensible convergence'
     */
    public function bs()
    {
        $result = array();
        foreach (static::$bsWords as &$word) {
            $result[] = static::randomElement($word);
        }

        return join(' ', $result);
    }

    /**
     * Employer Identification Number (EIN)
     *
     * @link https://en.wikipedia.org/wiki/Employer_Identification_Number
     * @example '12-3456789'
     */
    public static function ein()
    {
        $prefix = static::randomElement(static::$einPrefixes);
        $suffix = static::numberBetween(0, 9999999);

        return sprintf("%02d-%07d", $prefix, $suffix);
    }
}
