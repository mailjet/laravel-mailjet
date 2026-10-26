# Changelog

## 3.2.1 (2026-10-26)
- Security: the package always connects to the Mailjet API over HTTPS (ahead of the Mailjet API HTTP deprecation). The `secured` option is forced to `true`, and a scheme given in the `url` option (e.g. `http://api.mailjet.com`) is stripped
- Docs: `secured` / `url` options documented as HTTPS-only, outdated `http://` links updated

## 3.2.0
- See the [GitHub releases](https://github.com/mailjet/laravel-mailjet/releases) for earlier versions
