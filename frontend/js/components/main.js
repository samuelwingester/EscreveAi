import { HeaderPadrao } from './header.js';
import { Step } from './step.js';
import { Benefit } from './benefit.js';
import { Field } from './field.js';
import { HeaderBase } from './headerBase.js';
import { MenuOption } from './menuOption.js';
import { Base } from './base.js'

customElements.define('my-benefit', Benefit);
customElements.define('my-field', Field);
customElements.define('header-padrao', HeaderPadrao);  
customElements.define('my-step', Step); 
customElements.define('header-base', HeaderBase);
customElements.define('menu-option', MenuOption);
customElements.define('my-base', Base);