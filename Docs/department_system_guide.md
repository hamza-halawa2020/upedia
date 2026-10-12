# Department Management System Guide

The Department system allows admins to organize navigation access per organizational unit. It integrates with the Tab system to provide customized sidebars for different departments.

## Core Features

### 1. Department Listing & Search
- **Overview**: View all departments in a structured table.
- **Search**: Quickly find departments by name using the search bar.
- **Pagination**: Adjust the number of departments displayed per page (5 to 100).

### 2. Assigning Tabs (Access Control)
This is the core feature of the department system. It allows you to define exactly which navigation items (Tabs) are visible to members of a specific department.

- **Hierarchical View**: Tabs are grouped into accordions (Parent Groups and their Children) for easy organization.
- **Selection Tools**: 
    - **Global Select/Unselect All**: Quickly toggle all available tabs.
    - **Section Select/Unselect All**: Toggle tabs only within a specific parent group (e.g., toggle all HR-related tabs at once).
- **Custom Ordering**: 
    - You can specify a custom **Order** for each tab *within the context of the department*.
    - This allows different departments to have different sidebar sequences for the same set of tabs.
    - The "Order" field becomes active only when a tab is selected.

---

## Permissions

The following permissions are required to manage departments:

| Feature | Permission Name |
| :--- | :--- |
| View Departments List | `general_departments_index` |
| View/Edit Department Tabs | `general_departments_update` |
| Save Tab Assignments | `general_departments_update` |

---

## Best Practices
- **Groups vs. Links**: When assigning a parent tab (Group), ensure its children are also reviewed for consistent navigation.
- **Order Values**: Use logical increments (10, 20, 30) for order values to allow for future insertions without renumbering everything.
