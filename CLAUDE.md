# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**PreZero Scanit** is an environmental impact assessment platform for circular economy. Users scan second-hand items via QR-code stations, AI identifies the items, and verified environmental data calculates CO2/water/energy savings from reuse vs. new purchase.

**Stack:** Laravel 12, Livewire 3.6, Jetstream 5 (teams), Tailwind CSS, Vite

## Development Commands

```bash
# Full development stack (server + queue + logs + vite)
composer dev

# Individual services
php artisan serve              # Laravel server
php artisan queue:listen       # Queue worker (required for AI processing)
php artisan pail               # Real-time log viewer

# Code formatting
php artisan pint

# Frontend
npm run dev                    # Vite dev server
npm run build                  # Production build

# Testing
php artisan test               # Run all tests
php artisan test --filter=TestName  # Run specific test

# Database
php artisan migrate            # Run migrations (never use migrate:fresh without explicit permission)

# Custom commands
php artisan app:reprocess-inventories   # Reprocess failed/queued AI analyses
php artisan app:purge-archived-items    # Cleanup archived inventory items
```

## Architecture

### Core Domain Flow
1. **Public Station** (`/s/{uuid}`) → Visitor scans items via QR code
2. **ScanningSession** created with GDPR consent
3. **Inventory** records created for each scanned item (image uploaded via Spatie Media Library)
4. **ProcessScannedInventory** job → AIService analyzes image → structured JSON response
5. **ProcessScanningSession** job → aggregates metrics, triggers report email
6. **Environmental Report** sent to visitor with CO2 savings breakdown

### AI Integration (Identification Only)
- **Primary:** Anthropic Claude (`claude-opus-4-7`) - configured in `app/Services/AIService.php`
- **Fallback:** OpenAI (`gpt-5-mini`)
- **IMPORTANT:** AI only identifies items (name, category, condition). Environmental KPIs come from verified database.
- Prompt caching enabled for cost efficiency
- Config: `config/ai.php`, env vars: `AI_DEFAULT_PROVIDER`, `ANTHROPIC_API_KEY`, `OPENAI_API_KEY`

### Verified Environmental Factors (CRITICAL)
Environmental KPIs (CO2, water, energy) are **NOT AI-generated**. They come from a verified database with official sources:

**Sources:**
- IVL Svenska Miljöinstitutet (Second Hand Effect, IT-produkter)
- Naturskyddsföreningen (Andra hand i första hand)
- Naturvårdsverket/RISE (Klimatdata för textilier)

**Architecture:**
1. AI identifies item → category matching
2. `EnvironmentalFactorService` looks up verified factors
3. Each KPI has source citation, methodology, and verification date

**Key Models:**
- `EnvironmentalCategory` - Product categories with keywords for matching
- `EnvironmentalFactor` - CO2/water/energy values with full source tracking
- `EnvironmentalSource` - Official report references

**Commands:**
```bash
php artisan app:seed-environmental-factors        # Seed/update verified data
php artisan app:seed-environmental-factors --fresh # Reset and reseed
```

**Adding New Factors:**
Edit `database/seeders/EnvironmentalFactorsSeeder.php`. All data MUST have:
- Official source (research institute, government agency)
- Publication date
- Methodology (LCA ISO 14040-44 preferred)
- Source URL

### Key Models & Relationships
- **Customer** → has many Facilities (enterprise multi-tenant)
- **Facility** → has many Stations (physical locations with branding)
- **Station** → has many ScanningSessions (public scanning endpoint via `public_uuid`)
- **ScanningSession** → has many Inventories (batch of scanned items)
- **Inventory** → AI analysis results, CO2/water/energy metrics, status tracking

### Status Flow (Inventory)
`STATUS_QUEUED` → `STATUS_PROCESSING` → `STATUS_COMPLETED` | `STATUS_ERROR`

### Livewire Components
Located in `app/Livewire/`:
- `Dashboard.php` - Analytics with period filtering, Chart.js data
- `Facilities/` - CRUD for facilities
- `Stations/` - CRUD for stations + QR code generation
- `Reports/` - Environmental impact, CSRD reporting, exports
- `PublicScanningPage.php` - Public-facing scanning interface

### Authentication
- OTP-based login (no passwords) via `OtpController`
- Rate limited: 5 attempts per 10 minutes
- Jetstream teams with roles: `admin` (full CRUD), `editor` (read/create/update)

## Key Patterns

### Jobs (Database Queue)
All AI processing is async via jobs in `app/Jobs/`:
- 3 retries with 60s backoff
- 180s timeout for AI analysis
- Always run `php artisan queue:listen` during development

### File Uploads
Uses Spatie Media Library. Images attached to Inventory model.

### Exports
Excel/PDF exports via Maatwebsite Excel and DomPDF in `app/Exports/`.

### Localization
Bilingual EN/SV. Translations in `lang/en/scanit.php` and `lang/sv.json`.

## Environment Variables

Key variables beyond standard Laravel:
```
AI_DEFAULT_PROVIDER=anthropic
ANTHROPIC_API_KEY=
ANTHROPIC_MODEL=claude-opus-4
OPENAI_API_KEY=
OPENAI_MODEL=gpt-5-mini
TURNSTILE_SITE_KEY=     # Cloudflare CAPTCHA
TURNSTILE_SECRET_KEY=
```

## Server / Deployment

### PreZero Scanit Production
- **URL:** https://scanit.prezeroplus.com
- **Server IP:** 70.34.207.29
- **SSH:** `ssh forge@70.34.207.29`
- **Path:** `/home/forge/scanit.prezeroplus.com`

## Tailwind Theme

Custom PreZero brand colors defined in `tailwind.config.js`:
- `prezero-green: #97d700`
- `prezero-teal: #005151`
- `prezero-dark: #1a2634`
