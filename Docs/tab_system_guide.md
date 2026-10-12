# Tab Management System Guide

The Tab system allows admins to manage the dashboard's navigation structure dynamically. It supports hierarchical nesting, system tagging, and Export operations via CSV.

## Key Concepts

### 1. Tab Types
- **Group (Container)**: A tab with **no URL**. It serves as a parent for other tabs (e.g., "Human Resources").
- **Link**: A tab with a **URL**. This is a clickable navigation item that takes the user to a specific page.

### 2. Systems
Systems are used to categorize tabs and control their visibility. 
- **Targeted Visibility**: The primary goal is that when a **Super Admin** enters a specific system environment (e.g., HR, CRM, or Settings), the sidebar will dynamically filter the navigation to show **only** the tabs associated with that system.
- **Example**: If a tab is tagged with `hr`, it will only appear in the sidebar when the user is navigating the HR system.

### 3. Nesting
- Tabs can have a **Parent Tab**.
- If a tab has a parent, it will appear as a sub-item under that parent in the navigation.

---

## Managing Tabs via Dashboard

### Creating a Parent Tab Only Without Url
1. Navigate to the **Tabs Management** page.
2. Click on **Create Tab**.
3. Fill in the following fields:
    - **Label**: The display name of the tab.
    - **Icon**: An icon identifier (e.g., `ion:people` or `lucide:folder`).
    - **Order**: A number to determine the display sequence (lower numbers appear first).
    - **Systems**: Select or type the systems this tab belongs to.

### Filtering and Searching
You can filter the list of tabs by:
- **Search**: By label.
- **Parent Tab**: To see sub-items of a specific group.
- **System**: To see tabs belonging to a specific system.
- **Type**: Filter by Link or Group.

---

### Exporting
- **Export All**: Downloads a CSV of all current tabs.
- **Export Filtered**: If you have active filters, the export will only contain the filtered results.

## Permissions

The following permissions are required to access Tab features:

| Feature | Permission Name |
| :--- | :--- |
| View Tabs List | `general_tabs_index` |
| Export Tabs / Template | `general_tabs_index` |
| Create / Update Tabs | `general_tabs_update` |
| Import CSV | `general_tabs_update` |
