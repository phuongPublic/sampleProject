/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 50);
/******/ })
/************************************************************************/
/******/ ({

/***/ 50:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(51);


/***/ }),

/***/ 51:
/***/ (function(module, exports) {


$(document).ready(function () {
    // get company info
    $(".get-workplace").on("click", function () {
        copyCompanyInfo();
        return;
    });

    // get company info
    $(".get-company-info").on("click", function () {

        var id = this.id;
        var interview = false;
        var alias = 'workplace';
        if (id.indexOf('interview') >= 0) {
            interview = true;
            alias = 'interview';
        }

        if (typeof prefectureInfo != 'undefined' && prefectureInfo.length > 0) {
            if (prefectureInfo.status == 200) {
                if (prefectureInfo.results == null) {} else {
                    setCompanyInfo(prefectureInfo, alias, interview);
                }
            } else {
                showMessage(prefectureInfo.message);
            }

            return;
        } else {
            $.ajax({
                type: "POST",
                url: '/job/get-company-address',
                dataType: 'json',
                data: {},
                success: function success(json) {
                    prefectureInfo = json;
                    if (json.status == 200) {
                        if (json.results == null) {} else {
                            setCompanyInfo(json, alias, interview);
                        }
                    } else {
                        showMessage(json.message);
                    }

                    return;
                },
                beforeSend: function beforeSend() {
                    $('.loader_gb').addClass('show');
                },
                complete: function complete() {
                    $('.loader_gb').removeClass('show');
                }
            });
        }
        return;
    });

    function setCompanyInfo(prefectureInfo, alias, interview) {
        resetSelect(alias + '_city1');
        $('#' + alias + '_city1').prop("disabled", false);
        resetSelect(alias + '_city2');
        $('#' + alias + '_city2').prop("disabled", false);
        // attach city 1
        if (prefectureInfo.attach_city1 && prefectureInfo.attach_city1.length > 0) {
            $.each(prefectureInfo.attach_city1, function (index, value) {
                setAddress2(value, alias + '_city1');
            });
        }
        // attach city 2
        if (prefectureInfo.attach_city2 && prefectureInfo.attach_city2.length > 0) {
            $.each(prefectureInfo.attach_city2, function (index, value) {
                setAddress2(value, alias + '_city2');
            });
        }

        setAddress(prefectureInfo.results.city1, alias + '_city1', true);
        setAddress(prefectureInfo.results.city2, alias + '_city2', true);
        setValuetoInput(prefectureInfo.results.prefecture, alias + '_prefecture');
        setValuetoInput(prefectureInfo.results.detail_address, alias + '_detail_address');
        setValuetoInput(prefectureInfo.results.building_name, alias + '_building_name');
        setValuetoInput(prefectureInfo.results.building_name, alias + '_building_name_en');
        if (interview == true) {
            setValuetoInput(prefectureInfo.results.post_cd, alias + '_place_post_cd');
        } else {
            setValuetoInput(prefectureInfo.results.post_cd, alias + '_post_cd');
        }
    }

    function copyCompanyInfo() {
        cloneInput('workplace_post_cd', 'interview_place_post_cd');
        cloneInput('workplace_prefecture', 'interview_prefecture');

        cloneSelectBox('workplace_city1', 'interview_city1');
        cloneSelectBox('workplace_city2', 'interview_city2');

        cloneInput('workplace_detail_address', 'interview_detail_address');
        cloneInput('workplace_building_name', 'interview_building_name');
        cloneInput('workplace_building_name_en', 'interview_building_name_en');
        cloneInput('workplace_nearest_station_cd', 'interview_nearest_station_cd');
        cloneInput('workplace_nearest_station_name_source', 'interview_nearest_station_name_source');
        cloneInput('workplace_nearest_station_source_cd', 'interview_nearest_station_source_cd');
        cloneInput('workplace_nearest_station_move_type', 'interview_nearest_station_move_type');
        cloneInput('workplace_nearest_station_move_time', 'interview_nearest_station_move_time');

        return;
    }
});

/***/ })

/******/ });