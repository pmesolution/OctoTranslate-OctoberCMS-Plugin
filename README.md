Translation plugin created by PMESolution

## Frontend
### Language switcher

to add language switcher for frontend you have to edit the theme layout and add this code [Switcher] in the heading

so the default

```
description = "Default layout"
[session]
security = "all"


```
became like this

```
description = "Default layout"
[session][Switcher]
security = "all"

```
This will allow the access to the new twig tag and will let you to use the component anywhere in your theme files {% component 'Switcher' %}, 

#### HREFLANG


### Translation page

#### a) URL and routing

By default octobercms allow to have every page with a different url depending of language . Our translation plugin will detect and will not process string translation * for pages with specific language urls made manually . /en/ , /fr/ or others. The plugin use 2 letters iso code to detect the language of the page.

#### b) Common partials

Partial need the string translation because it will display the same contents for every page of your theme.  (Footer, sidebars , headers, menu)

### Strings translation


Especially made for the partials and elements that can't be translated using simple url, string translation will allow you to manage in the backend, the translation of every strings. The text can be detected and translated using the special language filters like this.

Default :

		<span>Text to translate</span>

Became : 

		<span>{ 'Text to translate' | l}</span>


The plugin will register all the strings to the database and you will be able to translate in every languages needed in the backend string translation page.


##Backend management


### Add new language


### Translating strings