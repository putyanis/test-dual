export class ProjectsController {
    projectTypes;
    projects;

    constructor(props) {
        this.projectTypes = Array.from(document.querySelector(props.projectTypesSelector).children);
        this.projects = Array.from(document.querySelectorAll(props.projectsSelector));
        console.log(this.projects);

        this.projectTypes.forEach((type) => {
            type.addEventListener("click", (e) => {
                e.preventDefault();
                this.showNewType(type.dataset.type);
            });
        });
    }

    showNewType(newType) {
        this.projectTypes.forEach((type) => {
            type.classList.toggle("active", type.dataset.type === newType);
        });

        this.projects.forEach((project) => {
            project.hidden = project.dataset.type !== newType;
        });
    }
}
