LdapBundle
==========

LDAP bundle for Symfony 2

### Configuring directory access

In the most basic case imaginable, a directory server residing on the same
machine as your Symfony2 project, you won't need to configure anything.

Usually, however, the directory server(s) will live somewhere else. Sometimes
you may also want to specify a fallback server, and/or use more than just one
directory. In those cases you need to put a bit of configuration into your
project's config.yml.

### Example configuration

This example specifies one directory with master and fallback servers. If
you name your directory `default`, like in this example, you can omit the
`default_directory` option (because `default` is its default value).

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