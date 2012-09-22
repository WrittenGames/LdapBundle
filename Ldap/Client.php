<?php

namespace WG\LdapBundle\Ldap;

class Client
{
    protected $link;
    protected $directories;
    protected $directory;
    
    public function __construct( array $directories, $defaultDirectoryName )
    {
        $this->directories = $directories;
        $this->directory = $directories[$defaultDirectoryName];
    }

    /**
     * Connect to directory
     * 
     * @param string $directoryName
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function connect( $directoryName = '' )
    {
        if ( $directoryName )
        {
            if ( !isset( $this->directories[$directoryName] ) )
            {
                throw new \InvalidArgumentException( 'WGLdapBundle says "Directory \'' . $directoryName . '\' is not defined."' );
            }
            $this->directory = $this->directories[$directoryName];
        }
        foreach ( $this->directory['servers'] as $server )
        {
            $this->link = @ldap_connect( $server['host'], $server['port'] );
            if ( $this->link ) break;
        }
        if ( !$this->link )
        {
            throw new \Exception( 'Could not connect to directory server.' );
        }
        return $this;
    }

    /**
     * Bind to directory
     * 
     * If $relativeDistinguishedName and $password are not
     * supplied, the client will attempt an anonymous bind
     * 
     * @param string $relativeDistinguishedName
     * @param string $password
     * @return boolean
     */
    public function bind( $relativeDistinguishedName = null, $password = null )
    {
        @ldap_set_option( $this->link, LDAP_OPT_PROTOCOL_VERSION,   $this->directory['protocol_version'] );
        @ldap_set_option( $this->link, LDAP_OPT_REFERRALS,          $this->directory['referrals'] );
        @ldap_set_option( $this->link, LDAP_OPT_NETWORK_TIMEOUT,    $this->directory['network_timeout'] );
        if ( @ldap_bind( $this->link, $relativeDistinguishedName, $password ) ) return $this;
        return false;
    }

    /**
     * Search in directory and retrieve results
     * 
     * @param string $baseDn
     * @param string $filter
     * @return array
     */
    public function search(
                      $baseDn,
                      $filter,
                      $attributes = null,
                      $attrsonly = null,
                      $sizelimit = null,
                      $timelimit = null,
                      $deref = null
                    )
    {
        $res = @ldap_search(
                  $this->link,
                  $baseDn,
                  $filter,
                  $attributes,
                  $attrsonly,
                  $sizelimit,
                  $timelimit,
                  $deref
                );
        return @ldap_get_entries( $this->link, $res );
    }
    
    // TODO: implement more methods
    public function foo()
    {
        return 'foo';
    }
}
