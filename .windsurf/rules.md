# Windsurf Coding Rules and Standards

## Error Handling

### Exception Reporting
- **Always use `report()` in try-catch blocks**: When catching exceptions, always call `report($e)` to send the error to Sentry for monitoring and debugging.
- **Example**:
  ```php
  try {
      // risky operation
  } catch (\Exception $e) {
      // Report error to Sentry
      report($e);
      
      // Handle error gracefully
      return response()->json(['error' => 'Something went wrong'], 500);
  }
  ```

## Authentication & OAuth

### Google OAuth Implementation
- Use standard Laravel OAuth redirect flow (not API-based)
- Leverage existing `/auth/*` routing to backend
- Use `<a href="">` tags instead of JavaScript redirects for simplicity
- Store intended URL in session for post-auth redirects
- Always redirect users back to where they came from after authentication

## Frontend Standards

### SvelteKit Components
- Use semantic HTML elements when possible (`<a>` instead of `<button>` for navigation)
- Leverage SvelteKit stores (`$page`, `$user`) for reactive data
- Keep components simple and focused on single responsibilities

## Database & Models

### User Management
- Use existing avatar/image system instead of creating new avatar fields
- Integrate with existing Laravel Sanctum authentication
- Follow existing database patterns and relationships

## Environment Configuration

### Required Variables
- Always update `.env.example` when adding new environment variables
- Use descriptive variable names
- Provide sensible defaults where appropriate

## Code Organization

### File Structure
- Follow existing project patterns
- Keep related functionality grouped together
- Document complex integrations with comprehensive guides

## Security

### OAuth Security
- Always use HTTPS in production
- Validate and sanitize user inputs
- Use Laravel's built-in security features (CSRF, Sanctum tokens)
- Follow OAuth 2.0 best practices
