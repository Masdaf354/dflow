# Change Management Tools Planning

## 1. Konsep Besar Sistem

Tujuan: - Mengontrol semua perubahan aplikasi - Tracking request,
approval, development, dan deployment

------------------------------------------------------------------------

## 2. Modul Utama

1.  Change Request
2.  Workflow & Approval
3.  Development Tracking
4.  Deployment Tracking
5.  Dashboard Monitoring

------------------------------------------------------------------------

## 3. Struktur Data

### change_requests

-   id
-   code
-   title
-   description
-   reason
-   change_type
-   impact
-   risk
-   rollback_plan
-   testing_plan
-   status
-   created_by
-   created_at

### change_approvals

-   id
-   change_request_id
-   approver_id
-   status
-   notes
-   approved_at

### change_deployments

-   id
-   change_request_id
-   environment
-   status
-   deployed_at

### change_development

-   id
-   change_request_id
-   git_branch
-   repository
-   developer_id
-   status

### change_logs

-   id
-   change_request_id
-   action
-   description
-   created_by
-   created_at

------------------------------------------------------------------------

## 4. Template Change Request

-   Judul
-   Deskripsi
-   Alasan
-   Jenis Perubahan
-   Dampak
-   Risiko
-   Rollback Plan
-   Testing Plan
-   Approval

Tambahan: - Priority - Affected Module - Target Release Date

------------------------------------------------------------------------

## 5. Workflow

DRAFT → SUBMITTED → APPROVED → IN PROGRESS → CODE REVIEW → MERGED →
DEPLOYED → DONE

------------------------------------------------------------------------

## 6. Integrasi Git

Naming: feature/CR-XXXX bugfix/CR-XXXX

------------------------------------------------------------------------

## 7. Tracking Environment

DEV → UAT → STAGING → PRODUCTION

------------------------------------------------------------------------

## 8. Dashboard

-   Summary Cards
-   Change Status Chart
-   Deployment Progress
-   High Risk Changes
-   Developer Activity
-   Lead Time Tracking
-   Failed Monitoring

------------------------------------------------------------------------

## 9. UI Pages

-   Change Request List
-   Detail Change Request
-   Kanban Board
-   Deployment Tracker

------------------------------------------------------------------------

## 10. Role & Permission

-   Maker
-   Approver
-   Developer
-   Admin

------------------------------------------------------------------------

## 11. Tech Stack

-   Laravel
-   Inertia + React
-   JWT Auth

------------------------------------------------------------------------

## 12. Notifikasi

-   Email
-   WhatsApp (optional)

------------------------------------------------------------------------

## 13. Future Enhancement

-   CI/CD Integration
-   SLA Monitoring
-   Risk Scoring

------------------------------------------------------------------------

## Kesimpulan

Tools ini menggabungkan: - Ticketing - Task Management - DevOps
Tracking - Compliance (ISO 27001)
