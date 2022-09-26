# Garagist.Mjml

[![Latest stable version]][packagist] [![GitHub stars]][stargazers] [![GitHub watchers]][subscription] [![GitHub license]][license] [![GitHub issues]][issues] [![GitHub forks]][network]

[MJML] is a markup language to build responsive email templates by providing a semantic syntax and a rich standard component library.

## Usage

You can use this package with the official API from [MJML] or with [Docker] and the [MJML image from Adrian Rudnik].

### Use with the official API from MJML

To use it with the MJML API, set `apiEndpoint` to `true`. You also have to set the `applicationID` and the `secretKey`. If you don't want to use the environment variables, you can simply overwrite them in your `Settings.yaml` file.

```yaml
Garagist:
  Mjml:
    apiEndpoint: true
    applicationID: "%env:MJML_API_APPLICATION_ID%"
    secretKey: "%env:MJML_API_SECRET_KEY%"
```

### Use with docker

Set the enviroment variable `MJML_API_ENDPOINT`, or set it in your `Settings.yaml`:

```yaml
Garagist:
  Mjml:
    apiEndpoint: "mjml:80"
```

### Development with ddev

If you use [ddev] for development, you can use the following configuration:

```yaml
version: "3.6"
services:
  mjml:
    container_name: ddev-${DDEV_SITENAME}-mjml
    hostname: ${DDEV_SITENAME}-mjml
    image: adrianrudnik/mjml-server
    labels:
      com.ddev.site-name: ${DDEV_SITENAME}
      com.ddev.approot: $DDEV_APPROOT
    environment:
      - HTTP_EXPOSE=8080
      - CORS=*
      - MJML_KEEP_COMMENTS=true
      - MJML_VALIDATION_LEVEL=strict
      - MJML_MINIFY=false
      - MJML_BEAUTIFY=true
      - HEALTHCHECK=false
```

After that, your MJML endpoint is something like `ddev-DDEV_SITENAME-mjml:80`

## Mixin to hide nodes

This package adds a node type mixin [`Garagist.Mjml:Mixin.Visibility`]. With this, you can show content nodes
only on the website or in the newsletter. Just add the mixin to your content nodes:

```yaml
Foo.Bar:Content.Text:
  superTypes:
    Garagist.Mjml:Mixin.Visibility: true
```

## Fusion prototypes

This package adds several Fusion prototypes for easier integration of your `MJML` markup. Let's start with the small ones:

### [`Garagist.Mjml:Presentation.Spacer`]

This is great for adding a spacer between elements. If you want to add a colored, full-width bar with a height of 40px, you can do it like that:

```elm
<Garagist.Mjml:Presentation.Spacer fullWidth={true} height={40} background-color="#00adee" />
```

All properties except `fullWidth` and `height` are transferred to the [`mj-section`].

### [`Garagist.Mjml:Presentation.Image`]

This is a small helper to render [`mj-image`] or [`mj-carousel-image`]. Inside a [`mj-carousel`],
set `carousel` to `true` to render a [`mj-carousel-image`].

#### The `image` property

The `image` property is a `Neos.Fusion:DataStructure` where you can pass all options from [`Neos.Neos:ImageUri`].

#### The `thumbnail` property

The `thumbnail` property is a `Neos.Fusion:DataStructure` where you can pass all options from [`Neos.Neos:ImageUri`].
This is used to set a different image to have a thumbnail different than the image it's linked to. This has no effect
if `carousel` is set to `false`.

All properties except `carousel`, `image` and `thumbnail` are transferred to [`mj-image`] or [`mj-carousel-image`].

### [`Garagist.Mjml:Presentation.Page`]

### [`Garagist.Mjml:Page`]

[packagist]: https://packagist.org/packages/garagist/mjml
[latest stable version]: https://poser.pugx.org/garagist/mjml/v/stable
[github issues]: https://img.shields.io/github/issues/Garagist/Garagist.Mjml
[issues]: https://github.com/Garagist/Garagist.Mjml/issues
[github forks]: https://img.shields.io/github/forks/Garagist/Garagist.Mjml
[network]: https://github.com/Garagist/Garagist.Mjml/network
[github stars]: https://img.shields.io/github/stars/Garagist/Garagist.Mjml
[stargazers]: https://github.com/Garagist/Garagist.Mjml/stargazers
[github license]: https://img.shields.io/github/license/Garagist/Garagist.Mjml
[license]: LICENSE
[github watchers]: https://img.shields.io/github/watchers/Garagist/Garagist.Mjml.svg
[subscription]: https://github.com/Garagist/Garagist.Mjml/subscription
[mjml]: https://mjml.io
[mjml image from adrian rudnik]: https://hub.docker.com/r/adrianrudnik/mjml-server
[docker]: https://www.docker.com
[ddev]: https://ddev.com/
[`garagist.mjml:mixin.visibility`]: Configuration/NodeTypes.Mixin.Visibility.yaml
[`garagist.mjml:presentation.spacer`]: Resources/Private/Fusion/Presentation/Spacer.fusion
[`mj-section`]: https://documentation.mjml.io/#mj-section
[`garagist.mjml:presentation.image`]: Resources/Private/Fusion/Presentation/Image.fusion
[`mj-image`]: https://documentation.mjml.io/#mj-image
[`mj-carousel`]: https://documentation.mjml.io/#mj-carousel
[`mj-carousel-image`]: https://documentation.mjml.io/#mj-carousel
[`neos.neos:imageuri`]: https://neos.readthedocs.io/en/stable/References/NeosFusionReference.html#neos-neos-imageuri
[`garagist.mjml:presentation.page`]: Resources/Private/Fusion/Presentation/Page.fusion
[`garagist.mjml:page`]: Resources/Private/Fusion/Component/Page.fusion
