<!-- Visit Details Modal -->
<div class="modal fade" id="visitDetailsModal" tabindex="-1" aria-labelledby="visitDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="visitDetailsModalLabel">
                    <i class="fas fa-clipboard-list me-2"></i>Medical Visit Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="visitDetailsContent">
                    <!-- Content will be loaded here -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading visit details...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="printVisitBtn">
                    <i class="fas fa-print me-1"></i>Print
                </button>
                <button type="button" class="btn btn-success" id="editVisitBtn">
                    <i class="fas fa-edit me-1"></i>Edit Visit
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.visit-detail-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #007bff;
}

.visit-detail-section h6 {
    color: #007bff;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #495057;
    flex: 0 0 40%;
}

.detail-value {
    flex: 1;
    text-align: right;
    color: #212529;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-open {
    background-color: #fff3cd;
    color: #856404;
}

.status-closed {
    background-color: #d1ecf1;
    color: #0c5460;
}

.status-referred {
    background-color: #f8d7da;
    color: #721c24;
}

.visit-type-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.875rem;
    font-weight: 500;
}

.type-routine {
    background-color: #d4edda;
    color: #155724;
}

.type-emergency {
    background-color: #f8d7da;
    color: #721c24;
}

.type-followup {
    background-color: #d1ecf1;
    color: #0c5460;
}

.type-referral {
    background-color: #ffeaa7;
    color: #856404;
}

.vitals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.vital-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 1rem;
    text-align: center;
}

.vital-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #007bff;
}

.vital-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.medication-item, .treatment-item {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 0.75rem;
}

.medication-name, .treatment-name {
    font-weight: 600;
    color: #007bff;
    margin-bottom: 0.25rem;
}

.medication-details, .treatment-details {
    font-size: 0.875rem;
    color: #6c757d;
}

.notes-section {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 1rem;
    margin-top: 1rem;
}

.notes-content {
    font-style: italic;
    color: #495057;
    line-height: 1.6;
}
</style>

<script>
function showVisitDetails(visitId) {
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('visitDetailsModal'));
    modal.show();
    
    // Load visit details via AJAX
    fetch(`/clinic-staff/visits/${visitId}/details`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('visitDetailsContent').innerHTML = generateVisitDetailsHTML(data);
            
            // Set up action buttons
            document.getElementById('editVisitBtn').onclick = () => editVisit(visitId);
            document.getElementById('printVisitBtn').onclick = () => printVisit(visitId);
        })
        .catch(error => {
            console.error('Error loading visit details:', error);
            document.getElementById('visitDetailsContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error loading visit details. Please try again.
                </div>
            `;
        });
}

function generateVisitDetailsHTML(visit) {
    const statusClass = `status-${visit.status.toLowerCase()}`;
    const typeClass = `type-${visit.visit_type.toLowerCase().replace('-', '')}`;
    
    return `
        <!-- Student Information -->
        <div class="visit-detail-section">
            <h6><i class="fas fa-user me-2"></i>Student Information</h6>
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value">${visit.student.full_name}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Student Number:</span>
                <span class="detail-value">${visit.student.student_number}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Grade & Section:</span>
                <span class="detail-value">${visit.student.grade_section}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Age:</span>
                <span class="detail-value">${visit.student.age} years old</span>
            </div>
        </div>

        <!-- Visit Information -->
        <div class="visit-detail-section">
            <h6><i class="fas fa-calendar-alt me-2"></i>Visit Information</h6>
            <div class="detail-row">
                <span class="detail-label">Visit Date & Time:</span>
                <span class="detail-value">${visit.formatted_datetime}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Visit Type:</span>
                <span class="detail-value">
                    <span class="visit-type-badge ${typeClass}">${visit.visit_type}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="status-badge ${statusClass}">${visit.status}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Attending Staff:</span>
                <span class="detail-value">${visit.clinic_staff ? visit.clinic_staff.name : 'Not assigned'}</span>
            </div>
        </div>

        <!-- Medical Details -->
        <div class="visit-detail-section">
            <h6><i class="fas fa-stethoscope me-2"></i>Medical Details</h6>
            <div class="detail-row">
                <span class="detail-label">Chief Complaint:</span>
                <span class="detail-value">${visit.chief_complaint || 'Not specified'}</span>
            </div>
            
            ${visit.vitals && visit.vitals.length > 0 ? `
                <div class="mt-3">
                    <strong>Vital Signs:</strong>
                    <div class="vitals-grid">
                        ${visit.vitals.map(vital => `
                            <div class="vital-card">
                                <div class="vital-value">${vital.value}</div>
                                <div class="vital-label">${vital.type}</div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            ` : ''}
        </div>

        <!-- Diagnoses -->
        ${visit.diagnoses && visit.diagnoses.length > 0 ? `
            <div class="visit-detail-section">
                <h6><i class="fas fa-diagnoses me-2"></i>Diagnoses</h6>
                ${visit.diagnoses.map(diagnosis => `
                    <div class="medication-item">
                        <div class="medication-name">${diagnosis.diagnosis_name}</div>
                        <div class="medication-details">${diagnosis.description || 'No additional details'}</div>
                    </div>
                `).join('')}
            </div>
        ` : ''}

        <!-- Medications -->
        ${visit.medications && visit.medications.length > 0 ? `
            <div class="visit-detail-section">
                <h6><i class="fas fa-pills me-2"></i>Medications Prescribed</h6>
                ${visit.medications.map(medication => `
                    <div class="medication-item">
                        <div class="medication-name">${medication.medication_name}</div>
                        <div class="medication-details">
                            <strong>Dosage:</strong> ${medication.dosage} | 
                            <strong>Frequency:</strong> ${medication.frequency} | 
                            <strong>Duration:</strong> ${medication.duration}
                        </div>
                    </div>
                `).join('')}
            </div>
        ` : ''}

        <!-- Treatments -->
        ${visit.treatments && visit.treatments.length > 0 ? `
            <div class="visit-detail-section">
                <h6><i class="fas fa-hand-holding-medical me-2"></i>Treatments Given</h6>
                ${visit.treatments.map(treatment => `
                    <div class="treatment-item">
                        <div class="treatment-name">${treatment.treatment_name}</div>
                        <div class="treatment-details">${treatment.description || 'No additional details'}</div>
                    </div>
                `).join('')}
            </div>
        ` : ''}

        <!-- Notes -->
        ${visit.notes ? `
            <div class="visit-detail-section">
                <h6><i class="fas fa-sticky-note me-2"></i>Additional Notes</h6>
                <div class="notes-section">
                    <div class="notes-content">${visit.notes}</div>
                </div>
            </div>
        ` : ''}
    `;
}

function editVisit(visitId) {
    // Close modal and show alert for now
    bootstrap.Modal.getInstance(document.getElementById('visitDetailsModal')).hide();
    alert('Edit visit functionality coming soon!');
}

function printVisit(visitId) {
    // Show alert for now
    alert('Print visit functionality coming soon!');
}
</script>