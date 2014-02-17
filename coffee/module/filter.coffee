# если элемент пустой, то будем выдавать вместо описания "--"
angular.module('dataFilter',[])
  .filter 'isempty',()->
    (input)->
      if input? then input else '--'