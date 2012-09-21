LdapBundle
==========

LDAP bundle for Symfony 2

### Configuring directory access

In the most basic case, with the directory service residing on the same machine,
you won't need to configure anything.

In most cases, however, the directory server(s) will live somewhere else.
Sometimes you may also want to use more than one directory, and/or a fallback
for the primary server. In those cases you need to put a bit of configuration
into your project's config.yml.

### Example configuration

This example specifies one directory with master and fallback servers. If you
name your directory `default` you can leave out the `default_directory` option
(because `default` is its default value).

```
wg_ldap:
    default_directory: default
    directories:
        default:
            servers:
                primary:
                    host: ldap.example.com
                secondary:
                    host: ldap2.example.com
```

### Authentication

In case you want to make your users authenticate against a directory, add the
`authentication` section to your configuration, specify the directory to be
authenticated against, and provide it with the service ID of your user manager:

```
wg_ldap:
    authentication:
        directory: default
        user_manager: user_manager_id
```