export interface ICategory {
    id: string;
    name: string;
    slug: string;
    created_at: string;
    updated_at: string;
}

export interface ICategoryCreate {
    name: string;
    slug: string;
}

export interface ICategoryUpdate {
    id?: string;
    name?: string;
    slug?: string;
}