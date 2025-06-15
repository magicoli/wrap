# Auth - User Management and Authentication

Authentication, authorization, and user management systems.

## What goes here:
- ✅ **Base auth class** (`class-auth.php` - core auth functionality, base class)
- ✅ **User management** (`class-user.php` - user representation, sessions)
- ✅ **Email authentication** (`class-auth-email.php` - verification codes, no-registration auth)
- ✅ **WordPress integration** (`class-auth-wordpress.php` - existing wrap-wp plugin support)
- ✅ **Third-party auth** (`class-auth-someprovidername.php` - naming patter for other auth providers)

## What doesn't go here:
- ❌ **API endpoints** (go in `../api/class-auth-api.php`)
- ❌ **Web login forms** (go in `webui/`)
- ❌ **User interface** (go in `webui/`)
- ❌ **Email sending** (use composer packages)

## File naming convention:
- **Base class**: `class-auth.php` → `Wrap\Auth\Auth`
- **Provider classes**: `class-auth-{provider}.php` → `Wrap\Auth\Auth{Provider}`
- **Examples**: 
  - `class-auth.php` → `Wrap\Auth\Auth` (base class)
  - `class-auth-email.php` → `Wrap\Auth\AuthEmail`
  - `class-auth-wordpress.php` → `Wrap\Auth\AuthWordpress`
  - `class-auth-github.php` → `Wrap\Auth\AuthGithub`
  - `class-auth-someprovidername.php` → `Wrap\Auth\AuthProvidername`

## Class hierarchy:
```
Auth (base class)
├── AuthEmail (email verification)
├── AuthWordpress (wrap-wp plugin)
└── AuthGithub (OAuth provider)
```

## Key features:
- **Email-based authentication** - No forced registration
- **Delegated user management** - Clients invite users to projects
- **Optional authentication** - Public viewing, login for uploads only
- **WordPress integration** - Seamless with existing wrap-wp plugin
- **Granular permissions** - Read-only, upload, favorites, admin

## Permission levels:
1. **Read-only** - View content only
2. **Upload** - Can upload files to assigned projects
3. **Favorites/Selections** - Can create and share favorites
4. **Admin** - Full project management rights

## Examples:
- `class-user.php` - `Wrap\Auth\User` - User sessions, temporary tokens
- `class-auth-wordpress.php` - `Wrap\Auth\Auth_Wordpress` - Integration with wrap-wp plugin
- `class-access-control.php` - `Wrap\Auth\AccessControl` - Project permissions, folder access
