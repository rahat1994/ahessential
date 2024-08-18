/******/ (() => { // webpackBootstrap
/*!*********************!*\
  !*** ./src/view.js ***!
  \*********************/
// Get the solution category anchor element
const solutionCategoryAnchors = document.querySelectorAll('.solution-category-anchor');

// Get all the elements with class 'solutions'
const solutions = document.querySelectorAll('.solution');

// Add click event listener to the solution category anchor
solutionCategoryAnchors.forEach(solutionCategoryAnchor => {
  solutionCategoryAnchor.addEventListener('click', event => {
    // prevent the default action
    event.preventDefault();

    // console.log(event.target.dataset);
    // Get the category name
    const categoryName = event.target.dataset.solutionCategory;
    console.log(categoryName);
    if (categoryName === 'all') {
      solutions.forEach(solution => {
        solution.style.display = 'block';
      });
      return;
    }
    // Filter the solutions based on the category name
    solutions.forEach(solution => {
      let categories = solution.dataset.solution_categories;
      categories = categories.split(', ');
      console.log(categories);
      if (categories.includes(categoryName)) {
        solution.style.display = 'block';
      } else {
        solution.style.display = 'none';
      }
    });
  });
});
/******/ })()
;
//# sourceMappingURL=view.js.map