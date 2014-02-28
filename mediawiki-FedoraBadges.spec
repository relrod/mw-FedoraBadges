%define gitdate   20130901

Name: mediawiki-FedoraBadges
Version: 1.0
Release: 1.0.%{gitdate}git%{?dist}
Summary: A small FedoraBadges extension for MediaWiki

License: MIT
Group: Development/Tools
URL: https://github.com/CodeBlock/mw-FedoraBadges
Source0: mw-FedoraBadges-%{gitdate}.tar.gz
BuildArch: noarch
Requires: mediawiki119

%description
A MediaWiki extension for displaying your Fedora Badges on your user page.

%prep
%setup -q -n mw-FedoraBadges-master

%build

%install
rm -rf %{buildroot}
mkdir -p %{buildroot}%{_datadir}/mediawiki119/extensions/FedoraBadges
cp -a *.php %{buildroot}%{_datadir}/mediawiki119/extensions/FedoraBadges/

%files
%doc README.md LICENSE
%{_datadir}/mediawiki119/extensions/FedoraBadges

%changelog
* Sun Sep 01 2013 Ricky Elrod <codeblock@fedoraproject.org> - 1.0-0.1.20130901git
- Latest upstream.

* Thu Aug 29 2013 Ricky Elrod <codeblock@fedoraproject.org> - 1.0-0.2.20130829git
- Latest upstream.

* Thu Aug 29 2013 Ricky Elrod <codeblock@fedoraproject.org> - 1.0-0.1.20130829git
- Initial package.
