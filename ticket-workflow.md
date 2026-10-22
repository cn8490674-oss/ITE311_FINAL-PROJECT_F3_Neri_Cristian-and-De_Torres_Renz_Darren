# BantayTicket Workflow

## Project Overview
BantayTicket is a proposed web-based complaint and request ticketing system for Barangay Bagong Buhay. It helps organize resident concerns and allows authorized barangay personnel to track the progress of each ticket.

## System Workflow

### 1. Resident Information
The resident provides the required information. The system uses a resident record to connect the person to their submitted complaint or request.

### 2. Submit a Complaint or Request
The resident selects a category and enters a description of the concern. The system checks whether the required fields are complete.

### 3. Ticket Creation
If the information is valid, the system creates a unique ticket number and sets the initial status to **Submitted**.

### 4. Staff Review
Authorized barangay personnel review the ticket and update its status when work begins.

### 5. Status Tracking
The ticket may use these statuses:
- Submitted
- Under Review
- In Progress
- Resolved
- Closed

### 6. Resolution
When the concern has been handled, authorized personnel record a resolution summary and update the ticket status.

### 7. CMS Integration
Authorized personnel can manage public announcements and barangay service information through the Content Management System (CMS).

## Connection to Other Project Files
- `resident-profile.md` describes resident information records.
- `complaint-tracking.md` describes complaint and request tickets.
- `ticket-validation.md` describes the validation rules.
- `README.md` provides the overall project description.

## Expected Benefits
- Organized complaint and request records
- Easier tracking of ticket status
- Fewer incomplete submissions
- Improved access to barangay announcements

## Note
This file documents the proposed workflow. The system will require web pages, server-side processing, a database, and appropriate access controls before these functions can operate.
