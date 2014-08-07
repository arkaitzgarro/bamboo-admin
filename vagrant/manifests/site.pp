# -*- mode: ruby -*-
# vi: set ft=ruby :

group { 'puppet': ensure => present }

file { "/home/vagrant/bamboo-admin":
    ensure => "directory",
    owner  => "vagrant",
    group  => "vagrant",
    mode   => 775,
}

class {'apt':
    always_apt_update => true
}

package { [
    'imagemagick',
    'vim',
    'htop'
    ]:
    ensure => 'installed'
}

class { 'apache': 
    default_mods => false,
    mpm_module => 'prefork',
    user => 'vagrant',
    group => 'vagrant'
}

include apache::mod::rewrite
include apache::mod::php

apache::vhost { 'bamboo.dev':
    port        => '80',
    docroot     => '/home/vagrant/bamboo-admin/web',
    docroot_owner => 'vagrant',
    docroot_group => 'vagrant',
    directories => [
        { 
            path          => '/home/vagrant/bamboo-admin/web',
            options       => ['Indexes','FollowSymLinks','MultiViews'],
            allow_override => ['all'],
            allow => 'from All'
        },
    ],
    serveradmin => 'admin@bamboo.dev',
}

class { 'php': }

include php::extension::mysql
include php::extension::intl

class { 'composer':
    auto_update => true
}

class { 'mysql::server':
    root_password    => 'root'
}

class { 'mysql::client': }