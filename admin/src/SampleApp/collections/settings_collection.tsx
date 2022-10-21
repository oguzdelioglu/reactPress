import {
    AdditionalFieldDelegate,
    AsyncPreviewComponent,
    buildCollection,
    EntityCallbacks,
    ExtraActionsParams
} from "@camberi/firecms";

import { SampleExtraActions } from "../collection_actions/SampleExtraActions";
import { Setting, Product } from "../types";


export const productExtraActionBuilder = ({
                                              selectionController
                                          }: ExtraActionsParams) => {
    return (
        <SampleExtraActions
            selectionController={selectionController}/>
    );
};

export const settingsCollection = buildCollection<Setting>({
    path: "settings",
    // callbacks: categoryCallbacks,
    name: "Settings",
    singularName: "Setting",
    group: "Blog Settings",
    icon: "Setting",
    description: "Blog Settings",
    textSearchEnabled: true,
    permissions: ({
        authController
    }) => {
        const isAdmin = authController.extra?.roles.includes("admin");
        return ({
        edit: isAdmin,
        create: isAdmin,
        delete: isAdmin
        });
    },
    properties: {
        title: {
            dataType: "string",
            name: "Title",
            description: "Blog Title",
            clearable: true,
            validation: {
                required: true
            }
        },
        description: {
            dataType: "string",
            name: "Description",
            description: "Blog Description",
            clearable: true,
            validation: {
                required: false
            }
        },
        keywords: {
            dataType: "string",
            name: "Keywords",
            description: "Blog Keywords",
            clearable: true,
            validation: {
                required: false
            }
        },
        author: {
            dataType: "string",
            name: "Author",
            description: "Blog Author",
            clearable: true,
            validation: {
                required: false
            }
        },
        canonical: {
            dataType: "string",
            name: "Canonical",
            description: "Blog Canonical",
            clearable: true,
            validation: {
                required: true
            }
        },
        site_header_meta: {
            dataType: "string",
            name: "ADS Header",
            description: "Site Header Meta ADS",
            markdown: true,
            clearable: true,
            validation: {
                required: false
            }
        },
        site_ads_300_250: {
            dataType: "string",
            name: "ADS 300*250",
            description: "Site 300*250 ADS",
            markdown: true,
            clearable: true,
            validation: {
                required: false
            }
        },
        site_ads_fluid: {
            dataType: "string",
            name: "ADS Fluid",
            description: "Site Fluid ADS",
            markdown: true,
            clearable: true,
            validation: {
                required: false
            }
        },
        site_ads_responsive: {
            dataType: "string",
            name: "ADS Responsive",
            description: "Site Responsive ADS",
            markdown: true,
            clearable: true,
            validation: {
                required: false
            }
        }
    }
});
