(this.webpackJsonp=this.webpackJsonp||[]).push([["endereco-shopware6-client"],{"0aYq":function(e,t){e.exports='<div>\n    <sw-button-process\n            :isLoading="isLoading"\n            :processSuccess="isSaveSuccessful"\n            @process-finish="saveFinish"\n            @click="check"\n    >{{ $tc(\'endereco-api-check-button.button\') }}</sw-button-process>\n</div>\n'},"cd+c":function(e){e.exports=JSON.parse('{"endereco-api-check-button":{"title":"API Prüfung","success":"Verbindung wurde erfolgreich geprüft","error":"Verbindung konnte nicht hergestellt werden. Bitte prüfe den API Key und die Server URL","button":"Verbindung zum Endereco Server prüfen"}}')},dTJ3:function(e){e.exports=JSON.parse('{"endereco-api-check-button":{"title":"API Check","success":"Connection was successfully tested","error":"Connection could not be established. Please check the api key and the server url","button":"Test API connection"}}')},nMqF:function(e,t,n){"use strict";n.r(t);n("rVin");var o=n("0aYq"),r=n.n(o),c=Shopware,i=c.Component,s=c.Mixin;i.register("endereco-api-check-button",{template:r.a,props:["label"],inject:["enderecoSW6ClientAPITest"],mixins:[s.getByName("notification")],data:function(){return{isLoading:!1,isSaveSuccessful:!1}},computed:{pluginConfig:function(){for(var e=this.$parent;void 0===e.actualConfigData;)e=e.$parent;return e.actualConfigData.null}},methods:{saveFinish:function(){this.isSaveSuccessful=!1},check:function(){var e=this;this.isLoading=!0,this.enderecoSW6ClientAPITest.check(this.pluginConfig).then((function(t){t.success?(e.isSaveSuccessful=!0,e.createNotificationSuccess({title:e.$tc("endereco-api-check-button.title"),message:e.$tc("endereco-api-check-button.success")})):e.createNotificationError({title:e.$tc("endereco-api-check-button.title"),message:e.$tc("endereco-api-check-button.error")}),e.isLoading=!1}))}}});var u=n("cd+c"),a=n("dTJ3");Shopware.Locale.extend("de-DE",u),Shopware.Locale.extend("en-GB",a)},rVin:function(e,t){function n(e){return(n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function o(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function r(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}function c(e,t){return(c=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function i(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,o=u(e);if(t){var r=u(this).constructor;n=Reflect.construct(o,arguments,r)}else n=o.apply(this,arguments);return s(this,n)}}function s(e,t){return!t||"object"!==n(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function u(e){return(u=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var a=Shopware.Classes.ApiService,f=Shopware.Application,l=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&c(e,t)}(f,e);var t,n,s,u=i(f);function f(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"endereco-shopware6-client";return o(this,f),u.call(this,e,t,n)}return t=f,(n=[{key:"check",value:function(e){var t=this.getBasicHeaders({});return this.httpClient.post("_action/".concat(this.getApiBasePath(),"/verify"),e,{headers:t}).then((function(e){return a.handleResponse(e)}))}}])&&r(t.prototype,n),s&&r(t,s),f}(a);f.addServiceProvider("enderecoSW6ClientAPITest",(function(e){var t=f.getContainer("init");return new l(t.httpClient,e.loginService)}))}},[["nMqF","runtime"]]]);