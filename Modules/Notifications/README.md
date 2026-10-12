# Notifications Module

Shared notification feature module.

This module should be used by all domains instead of duplicating notification controllers and routes in each old project migration.

Responsibilities:

- Notification inbox.
- Mark one notification as read.
- Mark all notifications as read.
- Store/update browser device tokens.

Domain-specific notification composition can stay in domain services, but the delivery and inbox UI belong here.

