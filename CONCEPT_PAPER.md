# MemorialMap: A Web-Based Cemetery Management and Online Memorial Lot Reservation System

**Researchers:** Jose Victor Uy, Jameson Valera, John Carlo Marcelino

**Proposed Capstone Project Title:** MemorialMap: A Web-Based Cemetery Management and Online Memorial Lot Reservation System for Heritage Memorial Park

## Area of Analysis

This research investigates the development of a web-based cemetery management and online reservation system called MemorialMap, designed to digitize and streamline the operations of Heritage Memorial Park. The study focuses on creating an integrated platform that combines interactive geographic mapping, online lot reservation, pre-need plan e-commerce, and administrative management into a single cohesive system.

Heritage Memorial Park currently relies on manual, paper-based processes for lot inventory tracking, client records management, contract generation, and payment collection. Cemetery staff maintain physical ledgers for plot availability, burial records, and financial transactions. Potential clients must visit the memorial park in person to inquire about available lots, view pricing, and complete reservation paperwork. This manual approach creates significant operational inefficiencies: staff spend disproportionate time on clerical tasks, lot availability information becomes outdated between physical inventory checks, the lack of centralized records makes it difficult to track contract histories and burial assignments, and clients face friction in the reservation process.

The absence of an integrated digital system creates critical operational gaps:

- Lot inventory is tracked manually, making real-time availability checks impossible without physical inspection
- Client inquiries and reservations require in-person visits or phone calls during business hours
- Contract generation and payment tracking rely on manual data entry, increasing the risk of errors
- Burial records are stored in physical ledgers, complicating historical data retrieval
- Pre-need plan offerings are marketed through separate channels with no centralized e-commerce capability
- Columbarium niche management lacks a digital interface for browsing and reservation
- No automated notification system exists for contract milestones, payment reminders, or burial schedules
- Activity logs and audit trails are virtually nonexistent, reducing accountability

This research explores how an interactive web-based platform with integrated geographic information system (GIS) mapping, online reservation workflows, and administrative dashboards can transform cemetery management from a manual, fragmented process into a streamlined, data-driven operation.

## Background and Rationale of the Project/System

MemorialMap is designed to address the operational challenges faced by Heritage Memorial Park through a comprehensive digital transformation of its cemetery management and reservation processes. Currently, staff and clients rely entirely on manual methods: lot availability is maintained on paper maps and spreadsheets, contract documents are handwritten or typed individually, payment records are logged in physical ledgers, and burial schedules are coordinated through verbal communication and written notes. This dependency on manual processes introduces inefficiencies that compound as the memorial park grows.

Research in cemetery information systems has demonstrated that digitizing cemetery operations significantly improves administrative efficiency, reduces record-keeping errors, and enhances client satisfaction through self-service capabilities. Studies have shown that web-based reservation systems reduce transaction processing time and improve inventory accuracy. The integration of interactive maps with cemetery management systems enables intuitive lot selection, spatial visualization of available inventory, and accurate geographic record-keeping.

By implementing MemorialMap, the proposed system will:

- **Provide Interactive Lot Selection:** Allow clients to browse available memorial lots through an interactive Leaflet-based map with satellite imagery, visualizing plot locations, dimensions, and surroundings without requiring physical site visits
- **Enable Online Reservation:** Allow clients to submit reservation requests for lots, columbarium niches, and pre-need plans through a unified digital workflow
- **Generate Contracts and PDFs:** Automatically generate formal contract documents with client information, lot details, payment terms, and digital PDF export using dompdf
- **Track Payments and Installments:** Maintain full financial records including payment history, installment schedules, and outstanding balances
- **Manage Burial Records:** Record and track burials with deceased information, burial dates, plot assignments, and scheduling approvals
- **Offer Pre-Need Plans:** Provide e-commerce functionality for pre-need memorial, burial, and funeral service plans with online purchase capability
- **Manage Columbarium Niches:** Digitally manage columbarium niche inventory, pricing, and reservation workflows
- **Deliver Admin Dashboards:** Provide role-based administrative dashboards with key metrics, activity logs, and system notifications
- **Maintain Audit Trails:** Log all system activities for accountability and operational transparency
- **Generate Digital Documents:** Produce PDF contracts and reports for printing and digital archiving

## Features of the System

- **Interactive Cemetery Map:** Leaflet-based interactive map with Google Satellite tiles displaying memorial lots with color-coded availability status (available, reserved, occupied, full)
- **Online Lot Reservation:** Multi-step reservation workflow for lots, columbarium niches, and pre-need plans with auto-client creation
- **Automated Contract Generation:** Digital contract creation with dompdf PDF export, including all client, lot, payment, and terms details
- **Payment Management:** Full payment recording with cash, credit card, and installment plan support including installment breakdowns
- **Burial Scheduling and Approval:** Burial record management with approval workflow, scheduling, and historical records
- **Pre-Need Plan Store:** Browse and purchase memorial, burial, and funeral service plans by category with detailed feature listings
- **Columbarium Management:** Digital niche inventory with card-based browsing interface and reservation workflow
- **Admin Dashboard:** Key metrics display including total lots, available lots, active contracts, upcoming burials, pre-need plan counts, and available niches
- **Role-Based Access Control:** Admin and staff roles with appropriate middleware protection for administrative routes
- **Activity Logging:** System-wide activity log recording all CRUD operations with user attribution
- **Notification Inbox:** Internal notification system with mark-read and mark-all-read functionality
- **Quick Find / Search:** Public search interface for locating lots, clients, and records
- **Relocate and Edit Tools:** Administrative tools for repositioning plot markers on the map and editing lot details
- **Reservation Confirmation:** Post-reservation confirmation page with contract summary and PDF download link

## Modules

**Plot Management Module:** Handles CRUD operations for memorial lots including geographic coordinates (latitude/longitude), capacity tracking, occupancy status, pricing, section assignment, and interactive map positioning. Supports relocation of plot markers on the map via drag-and-drop.

**Client Management Module:** Manages client profiles with full name, contact information, address, and government-issued ID verification (PhilSys, Passport, UMID). Enables quick client lookup during reservation and contract creation.

**Contract Management Module:** Governs the entire contract lifecycle from creation through completion, including PDF generation via dompdf. Supports multiple payment types (cash, credit card, installment) and status tracking (active, completed, cancelled). Links contracts to plots, pre-need plans, and columbarium niches through foreign key relationships.

**Payment and Installment Module:** Records and tracks all financial transactions including one-time payments and installment schedules. Maintains payment history with reference numbers, receipt tracking, and outstanding balance calculations.

**Burial Management Module:** Manages burial records with deceased person information, date of birth and death, burial scheduling, plot assignment, and approval workflow. Tracks burial status through scheduling, completion, and historical archiving.

**Pre-Need Plan Module:** E-commerce module for pre-need memorial, burial, and funeral service plans. Plans are organized by type with detailed descriptions, feature lists, and pricing. Supports public browsing, filtering, and online application flow.

**Columbarium Module:** Digital inventory management for columbarium niches with section, row, tier, and pricing data. Provides card-based public browsing interface sorted by section, row, and tier.

**Interactive Mapping Module:** Leaflet-based GIS module providing Google Satellite tile layers, custom green dot markers (divIcons) for available lots, color-coded status indicators, click-to-zoom functionality (max zoom 20), popup information displays, maxBounds enforcement, and sidebar integration with fly-to navigation.

**User and Access Control Module:** Authentication system with admin/staff role assignment via middleware. Provides user registration, login, password reset, and profile management.

**Notification and Activity Log Module:** Internal notification system for system events and alerts. Activity logging tracks all user actions with timestamps for audit trail purposes.

**Reporting and Document Generation Module:** Generates PDF documents for contracts using dompdf library. Produces formatted contract documents with all relevant details for client printing and digital archiving.

**Public Search Module:** Enables public users to quickly find lots, view availability, and access reservation forms through a search interface with geolocation-aware results.

## Statement of Objectives

The primary objectives of this research are:

1. **Develop a Cemetery Management System:** Design and implement a comprehensive web-based platform called MemorialMap that digitizes the full lifecycle of memorial lot operations including inventory tracking, client management, contract generation, and burial record-keeping.

2. **Enable Interactive Map-Based Lot Selection:** Implement an interactive Leaflet-based map interface with Google Satellite imagery that allows clients to visually browse available lots, view pricing and capacity details, and make informed selections without requiring physical site visits.

3. **Provide Online Reservation and E-Commerce:** Create a unified online reservation workflow that allows clients to reserve memorial lots, columbarium niches, and purchase pre-need plans (memorial, burial, funeral) through a streamlined digital process with auto-generated contracts.

4. **Automate Contract and Document Generation:** Develop automated contract generation with PDF output using dompdf, reducing manual paperwork and ensuring standardized, accurate documentation for all transactions.

5. **Establish Financial Tracking and Installment Management:** Implement comprehensive payment recording with support for cash, credit card, and installment payment plans including automatic installment schedule tracking and balance monitoring.

6. **Digitize Burial Records and Scheduling:** Create a digital burial management system with scheduling, approval workflows, and historical record-keeping to replace paper-based ledgers.

7. **Deliver Role-Based Administrative Dashboards:** Provide customizable dashboards for admin and staff roles displaying key performance metrics, upcoming events, and system notifications.

8. **Ensure System Accountability:** Implement activity logging and notification systems to maintain audit trails and facilitate internal communication.

9. **Evaluate System Effectiveness:** Assess the system's impact on operational efficiency, data accuracy, and user satisfaction through testing with administrative staff and client workflows.

## Scope and Limitations of the Study

### Scope

The study will focus on developing a fully functional web-based prototype of MemorialMap designed specifically for Heritage Memorial Park. The system will be built using the Laravel PHP framework with a MySQL database backend, utilizing Leaflet.js for interactive mapping, Tailwind CSS for responsive front-end design, and dompdf for PDF document generation.

The system will cover:

- Complete plot inventory management with geographic coordinates, capacity, pricing, and availability tracking
- Interactive satellite map integration for lot visualization and selection
- Client profile management with ID verification (PhilSys, Passport, UMID) support
- Contract generation with multi-payment type support (cash, credit, installment)
- Online reservation workflow for lots, columbarium niches, and pre-need plans
- Burial record management with scheduling and approval workflows
- Pre-need plan store with browsing, filtering, and application flow
- Columbarium niche digital management and browsing
- Administrative dashboard with key metrics and activity monitoring
- Internal notification system and activity logging
- PDF contract generation and download
- Role-based access control (admin/staff)

### Limitations

- The system is designed exclusively for Heritage Memorial Park and may not directly accommodate the operational workflows, lot naming conventions, or pricing structures of other memorial parks without customization
- The interactive map uses Google Satellite tiles and requires internet connectivity; offline map functionality is outside the scope of this study
- Payment processing is limited to payment recording and tracking; actual online payment gateway integration (e.g., GCash, PayPal, credit card processing) is outside the scope of this study
- Real-time video or CCTV integration for lot viewing is not covered
- Mobile native application development is outside the scope; the system is designed as a responsive web application only
- The system does not integrate with external government databases for death certificate verification or civil registration
- Pre-need plan fulfillment and trust fund management are outside the scope; the system handles sales and contracts only
- Columbarium management covers reservation and inventory but not physical niche construction or maintenance scheduling
- The system does not include automated SMS or email notification integration; all notifications are in-system only
- Data migration from existing paper records is outside the implementation scope; manual data entry is required
- Multi-language support is not included; the system operates in English

## Target Beneficiaries

**Heritage Memorial Park Administration and Staff:** The primary beneficiaries. Administration gains real-time visibility into lot inventory, financial performance, and operational metrics. Staff benefit from streamlined workflows for client registration, contract processing, payment recording, and burial scheduling, reducing clerical workload and minimizing data entry errors.

**Clients and Families Seeking Memorial Lots:** Individuals and families planning ahead or needing immediate burial arrangements benefit from the ability to browse available lots online through the interactive map, view pricing and capacity details, submit reservation requests digitally, and receive automated contract documentation without requiring multiple in-person visits.

**Clients Purchasing Pre-Need Plans:** Individuals looking to pre-arrange memorial, burial, or funeral services benefit from the e-commerce functionality allowing them to browse plan options, compare features and pricing by type, and apply online with digital contract generation.

**Families Arranging Burials:** Families managing end-of-life arrangements benefit from streamlined burial scheduling, digital record-keeping, and clear documentation of plot assignments and contract terms.

**Students and Researchers in Cemetery Information Systems:** The project contributes to the limited body of research on cemetery management information systems in the Philippine context, providing a reference implementation for similar digitization efforts.

**Heritage Memorial Park as an Organization:** The memorial park benefits from improved operational efficiency, reduced administrative costs, enhanced client experience, better data accuracy, and the establishment of a centralized digital record system that ensures business continuity beyond individual staff knowledge.

## References

Adeyinka, S. A., & Osunade, O. (2020). Design and implementation of an online cemetery information management system. *International Journal of Computer Applications*, 175(12), 1-7.

Agoyi, M., & Seral, D. (2020). Web-based cemetery management system. *International Journal of Scientific & Technology Research*, 9(3), 4938-4942.

  C. M., , A. J., & , J. G. (2021). Cemetery information system with mapping and reservation. *International Research Journal of Advanced Engineering and Science*, 6(2), 85-89.

Bandaragoda, C. J., & Perera, I. (2022). A geographic information system (GIS) approach to cemetery management. *Journal of Spatial Science*, 67(1), 145-162.

Bhandari, R., & Shrestha, S. (2021). Digital transformation in funeral services: A systematic review. *International Journal of Information Management*, 58, 102-118.

Duke Reporters' Lab. (2025). Cemetery and interment record databases. Duke University.

International Cemetery, Cremation and Funeral Association (ICCFA). (2024). *Cemetery management best practices guide*. ICCFA Press.

Kumar, A., & Singh, R. (2022). Web-based geographic information system for land record management. *GIScience & Remote Sensing*, 59(4), 612-629.

Laravel LLC. (2025). *Laravel 12 documentation: Routing, Eloquent ORM, authentication, and broadcasting*. Laravel.

Leaflet.js Contributors. (2025). *Leaflet: An open-source JavaScript library for interactive maps*. https://leafletjs.com/

OpenStreetMap Foundation. (2024). *Tile usage policy and best practices for web mapping*. OSMF.

Philippine Statistics Authority. (2023). *Civil registration and vital statistics guidelines*. Republic of the Philippines.

Reyes, M. T., & Santos, J. L. (2022). Information systems for local government units: A case study of cemetery record digitization. *Philippine Journal of Public Administration*, 66(1), 78-95.

Singh, P., & Kaur, R. (2021). E-commerce adoption in service industries: Funeral and memorial services perspective. *Journal of Services Marketing*, 35(5), 601-615.

Tan, C. K., & Lim, S. H. (2023). Mobile and web geographic information systems for urban facility management. *International Journal of Urban Sciences*, 27(2), 234-251.

Thompson, D., & Martinez, L. (2020). Pre-need funeral planning: Consumer behavior and digital service adoption. *Journal of Consumer Affairs*, 54(3), 892-915.

Vosoughi, S., Roy, D., & Aral, S. (2018). The spread of true and false news online. *Science*, 359(6380), 1146-1151.

Zhao, Y., & Zhang, J. (2023). Database design patterns for cemetery information systems. In *Proceedings of the International Conference on Software Engineering and Information Management* (pp. 45-52). ACM.
