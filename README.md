# 🌤️ Breezy Weather — Team D  
**Purdue Global University | IT488: Software Product Development Using Agile**  
**Instructor:** Prof. Ahmad Kassem   
**Term:** October 2025  

A fast, modern, and responsive **Progressive Web App (PWA)** that provides real-time weather updates, location-based alerts, and multi-device accessibility.  
Developed collaboratively by **Team D** over four Agile sprints, Breezy Weather embodies simplicity, reliability, and the spirit of continuous improvement.

---

## 🧭 Project Overview
Breezy Weather enables users to view accurate, up-to-date weather data from reliable APIs.  
It supports location-based searches, favorites, and compass orientation with a visually clean interface.  

**Core Objectives**
- Deliver an intuitive user interface with strong performance.  
- Maintain responsive design across all devices.  
- Apply Agile principles through sprints, retrospectives, and QA testing cycles.  

---

## 🚀 Sprint Summary

| Sprint | Focus | Key Deliverables |
|:--:|:--|:--|
| **1** | Project Setup & Planning | Defined backlog, established repo, configured initial UI and fetch logic. |
| **2** | Core Development | Integrated API data, location search, and mobile responsiveness. |
| **3** | Feature Expansion | Added login, favorites, alerts, and compass functionality. |
| **4** | QA & Final Demo | Executed full QA cycle, finalized styling, and deployed v1.0.0. |

---

## 🧪 Demo QA Report — Sprint 4 (Final Week)

**Demo Date:** October 2025  
**Environment:** GitHub Pages (Frontend) + Render (Backend API)  
**QA Lead:** Tanner Smith  
**Support Testers:** Alisa Roberts, Rylie Evans, Sedjro Tovihouande, 

### 🎯 Objective
Ensure Breezy Weather meets acceptance criteria and operates without critical defects before release.

### ✅ QA Test Summary

| Test ID | Feature | Tester | Expected Result | Status |
|:--:|:--|:--|:--|:--|
| TC-01 | Login Persistence | Sedjro | Session remains active post-login | ✅ Passed |
| TC-02 | Favorites Add/Remove | Sedjro | Adds/removes cities correctly | ✅ Passed |
| TC-03 | Weather Alerts | Sedjro | Displays alerts dynamically | ✅ Passed |
| TC-04 | Compass Alignment | Rylie | Points to accurate wind direction | ✅ Passed |
| TC-05 | Responsive Layout | Rylie | Adapts to mobile and tablet screens | ✅ Passed |
| TC-06 | Offline Mode | Tanner | Cached version loads when offline | ✅ Passed |
| TC-07 | API Error Handling | Tanner | Shows “Network Error – Try Again” | ✅ Passed |

**Summary:**  
All **7 test cases passed** across browsers (Chrome, Edge, Firefox, Safari).  
No critical or high-severity bugs detected. Two minor UI issues were corrected before demo.  

**Performance:**  
- Load time: ~1.7 seconds average  
- Lighthouse Score: 98 / 100  
- Accessibility: 99 / 100  

---

## 📦 Release Notes (v1.0.0 Final)

- Integrated **Open Meteo** + **Nominatim APIs**.  
- Implemented **Favorites** and **Alerts** modules.  
- Improved **Compass** and **Theme Switching**.  
- Added **Offline Caching** via Service Worker for PWA.  
- Completed **Full QA** and **Demo Verification** during Sprint 4.  

---

## 🧠 Agile Reflection
Over four sprints, **Team D** followed Agile principles to plan, develop, and iterate the Breezy Weather App.  
Daily communication was maintained through Discord and GitHub Projects, with regular retrospectives after each sprint.

**Key Takeaways**
- Iterative testing strengthened overall product reliability.  
- Collaboration and consistent communication improved efficiency.  
- Team velocity increased as tasks became more structured per sprint.  

---

## 👥 Team D

| **Name** | **Role** | **Sprint 4 Responsibilities** |
|-----------|-----------|-----------------------------|
| **Tanner Smith** | QA Lead / Demo Presenter | Led final QA cycle and presented demo. |
| **Alisa Roberts** | Main Developer | QA Support | Executed spot-fixes and verified UI polish. |
| **Sedjro Tovihouande** | QA Login / Favorites / Alerts | Tested backend logic and resolved session persistence bugs. |
| **Rylie Evans** | Visual Design & Compass QA | Managed design consistency and compass performance. |

---

## 🧩 Features Overview
- Real-time forecast (temperature, humidity, UV index, wind)  
- GPS-based search + favorite cities management  
- Alerts for severe weather conditions  
- Compass feature tied to wind direction  
- PWA installation and offline use  
- Light/Dark theme toggle  

---

## ⚙️ Tech Stack

| Category | Technology |
|-----------|-------------|
| **Frontend** | HTML5, CSS3 (Tailwind), JavaScript (ES6) |
| **Backend / API** | Python (Flask), Open Meteo, Nominatim |
| **PWA** | Service Worker (`sw.js`), Web Manifest (`site.webmanifest`) |
| **Version Control** | GitHub / GitHub Projects |
| **Testing Tools** | Chrome DevTools, Console Debugging |
| **Collaboration** | Discord, Microsoft Teams, Google Docs |
| **Deployment** | GitHub Pages (Frontend), Render (Backend) |

---

## 💻 How to Run Locally

**Option A (Visual Studio Code)**  
1. Install the *Live Server* extension.  
2. Open the folder → Right-click on `index.html` → “Open with Live Server”.

**Option B (PowerShell)**  
```bash
Compress-Archive -Path * -DestinationPath breezy-weather.zip
