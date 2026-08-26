<!-- Company information Card -->
<template>
    <div class="card shadow-sm custom-border-radius">
        <div class="card-body">
            <div class="tab-pane active" id="company_info" role="tabpanel">
                <div
                    class="p-3"
                    style="max-height: 500px; overflow-y: auto"
                    ref="scrollContainer"
                    @mousedown="startDrag"
                    @mouseup="stopDrag"
                    @mouseleave="stopDrag"
                    @mousemove="onDrag"
                >
                    <table
                        class="table table-sm table-bordered align-middle mb-0 w-100"
                    >
                        <!-- Event Information Header -->
                        <thead class="table-borderless">
                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Event Information
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Event Name
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ event_info.event_name || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Location
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ event_info.location || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Date
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{
                                        event_info.event_start
                                            ? $moment(
                                                  event_info.event_start
                                              ).format("MMMM DD, YYYY")
                                            : "-"
                                    }}
                                    —
                                    {{
                                        event_info.event_end
                                            ? $moment(
                                                  event_info.event_end
                                              ).format("MMMM DD, YYYY")
                                            : "-"
                                    }}
                                </td>
                            </tr>
                            <!-- End Event Information Header -->

                            <!-- Company Information Header -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 border-0 bg-transparent"
                                ></td>
                            </tr>

                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Company Information
                                </th>
                            </tr>
                            <!-- Fascia Name -->
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Name to Appear on Fascia
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.fascia_name || "—" }}
                                </td>
                            </tr>

                            <!-- Exhibitor Information -->
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Supplier/Exhibitor Type
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{
                                        company_info.exhibitor_type == 1
                                            ? "New Supplier/Exhibitor"
                                            : company_info.exhibitor_type == 2
                                            ? "Returning Supplier/Exhibitor"
                                            : "—"
                                    }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Last Participated
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ company_info.last_participated || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Company Name
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ company_info.co_name || "—" }}
                                </td>

                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Directory Name
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ company_info.directory_name || "—" }}
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Phone Number
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ company_info.phone_no || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Mobile Number
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ company_info.mobile_no || "—" }}
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Website
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ company_info.website || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Email Address
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ company_info.co_email || "—" }}
                                </td>
                            </tr>

                            <!-- End Company Information Header -->

                            <!--Corporate Social Media Account -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 border-0 bg-transparent"
                                ></td>
                            </tr>
                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Corporate Social Media Account
                                </th>
                            </tr>
                            <tr
                                v-for="(field, label) in {
                                    Facebook: 'facebook',
                                    Twitter: 'twitter',
                                    Instagram: 'instagram',
                                    LinkedIn: 'linkedin',
                                }"
                                :key="field"
                            >
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    {{ label }}
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    <span v-if="company_info[field]">
                                        <a
                                            :href="`https://www.${label.toLowerCase()}.com/${
                                                company_info[field]
                                            }`"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            https://www.{{
                                                label.toLowerCase()
                                            }}.com/{{ company_info[field] }}
                                        </a>
                                    </span>

                                    <span v-else>—</span>
                                </td>
                            </tr>

                            <!-- Others -->
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Others
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    <span v-if="company_info.other_social">
                                        <a
                                            :href="company_info.other_social"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            {{ company_info.other_social }}
                                        </a>
                                    </span>
                                    <span v-else>—</span>
                                </td>
                            </tr>

                            <!-- End Corporate Social Media Account -->

                            <!-- Factory Address -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 border-0 bg-transparent"
                                ></td>
                            </tr>
                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Factory Address
                                </th>
                            </tr>
                            <tr>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Country
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.fa_country || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Province/State
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.fa_state || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    City/Town
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.fa_city || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Zipcode
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.fa_zipcode || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Region
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.fa_region || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Street
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.fa_street || "—" }}
                                </td>
                            </tr>
                            <!-- End Factory Address -->

                            <!-- Main Office Address -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 border-0 bg-transparent"
                                ></td>
                            </tr>
                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Main Office Address
                                </th>
                            </tr>
                            <tr>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Country
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.moa_country || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Province/State
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.moa_state || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    City/Town
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.moa_city || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Zipcode
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.moa_zipcode || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Region
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.moa_region || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Street
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ company_info.moa_street || "—" }}
                                </td>
                            </tr>
                            <!-- End Main Office Address -->

                            <!-- Contact Information Header -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 bg-transparent border-0"
                                ></td>
                            </tr>
                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Contact Information
                                </th>
                            </tr>
                            <!-- Business Owner -->
                            <tr>
                                <td
                                    colspan="6"
                                    class="fw-bold py-2 text-center bg-light border border-dark"
                                >
                                    Business Owner
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Salutation
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.salutation || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Firstname
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.fname || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Lastname
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.lname || "—" }}
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    M.I
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.mi || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Designation
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.designation || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Mobile No.
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.mobile_no_bo || "—" }}
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    E-mail
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ contact_info.email || "—" }}
                                </td>
                            </tr>

                            <!-- End Business Owner -->
                            <!-- Business Contact Person -->

                            <tr>
                                <td
                                    colspan="6"
                                    class="fw-bold py-2 text-center bg-light border border-dark"
                                >
                                    Business Contact Person
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Salutation
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.bcp_salutation || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Firstname
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.bcp_fname || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Lastname
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.bcp_lname || "—" }}
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    M.I
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.bcp_mi || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Designation
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.bcp_designation || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Mobile No.
                                </th>
                                <td class="py-2 border border-dark">
                                    {{ contact_info.bcp_mobile_no || "—" }}
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    E-mail
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ contact_info.bcp_email || "—" }}
                                </td>
                            </tr>

                            <!-- End Business Contact Person -->
                            <!-- End Contact Information Header -->

                            <!-- Business Information Header -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 bg-transparent border-0 bg-transparent"
                                ></td>
                            </tr>
                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Business Information
                                </th>
                            </tr>
                            <tr>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Start up
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ getStartUpStatus() }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Interested in SSX Conference?
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ interestedInSSXConference() }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Interested in becoming a sponsor for SSX
                                    2026?
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ interestedInSponsorship() }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Business Registration
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{
                                        business_info.business_type
                                            ? business_types.find(
                                                  (bt) =>
                                                      bt.id ===
                                                      business_info.business_type
                                              )
                                                ? business_types.find(
                                                      (bt) =>
                                                          bt.id ===
                                                          business_info.business_type
                                                  ).name
                                                : "—"
                                            : "—"
                                    }}
                                </td>
                                <th
                                    class="w-25 py-2 text-muted fw-bold border border-dark"
                                >
                                    Company Size
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{
                                        business_info.company_size
                                            ? company_sizes.find(
                                                  (cs) =>
                                                      cs.id ===
                                                      business_info.company_size
                                              )
                                                ? company_sizes.find(
                                                      (cs) =>
                                                          cs.id ===
                                                          business_info.company_size
                                                  ).name
                                                : "—"
                                            : "—"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Annual Sales Volume
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{
                                        business_info.annual_sales_volume
                                            ? annual_sales_volumes.find(
                                                  (as) =>
                                                      as.id ===
                                                      business_info.annual_sales_volume
                                              )
                                                ? annual_sales_volumes.find(
                                                      (as) =>
                                                          as.id ===
                                                          business_info.annual_sales_volume
                                                  ).name
                                                : "—"
                                            : "—"
                                    }}
                                </td>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Type of Organization
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{
                                        business_info.organization_type
                                            ? organization_types.find(
                                                  (ot) =>
                                                      ot.id ===
                                                      business_info.organization_type
                                              )
                                                ? organization_types.find(
                                                      (ot) =>
                                                          ot.id ===
                                                          business_info.organization_type
                                                  ).name
                                                : "—"
                                            : "—"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Direct Workers
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ business_info.direct || "—" }}
                                </td>

                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Indirect/Sub-Contractors
                                </th>
                                <td class="py-2 border border-dark" colspan="2">
                                    {{ business_info.indirect || "—" }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Nature Business
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{
                                        business_info.nature_business.length
                                            ? nature_businesses
                                                  .filter((nb) =>
                                                      business_info.nature_business.includes(
                                                          nb.id
                                                      )
                                                  )
                                                  .map((nb) => {
                                                      if (nb.id === 16) {
                                                          return business_info.nature_business_others
                                                              ? "Others: " +
                                                                    business_info.nature_business_others
                                                              : "Others";
                                                      }
                                                      return nb.name;
                                                  })
                                                  .join(", ")
                                            : "—"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Target Buyer & Intent
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{
                                        business_info.target_buyer.length
                                            ? target_buyers
                                                  .filter((t) =>
                                                      business_info.target_buyer.includes(
                                                          t.id
                                                      )
                                                  )
                                                  .map((t) => {
                                                      if (t.id === 6) {
                                                          return business_info.target_buyer_others
                                                              ? "Others: " +
                                                                    business_info.target_buyer_others
                                                              : "Others";
                                                      }
                                                      return t.name;
                                                  })
                                                  .join(", ")
                                            : "—"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Target Countries For Export (Top 3)
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{
                                        [
                                            getCountryName(
                                                business_info.target_country_1
                                            ),
                                            getCountryName(
                                                business_info.target_country_2
                                            ),
                                            getCountryName(
                                                business_info.target_country_3
                                            ),
                                        ]
                                            .filter((n) => n !== "")
                                            .join(", ") || "—"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Certification
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ getCertificationNames() }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Industry Representation
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ getIndustryRepLabel() }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Countries Exporting To (Top 3)
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ getExportingCountries() }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Specific Products/Services to be Promoted
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ business_info.product_promoted }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Supplier/Exhibitor Profile
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ getSelectedSubcategories() }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-2 text-muted fw-bold border border-dark text-start"
                                    colspan="6"
                                >
                                    Sustainable Development Goals (SDG)
                                    Alignment
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 border border-dark" colspan="6">
                                    <ul>
                                        <li
                                            v-for="(
                                                sg, index
                                            ) in getSelectedSdgs()"
                                            :key="index"
                                        >
                                            {{ sg }}
                                        </li>
                                        <li
                                            v-if="
                                                getSelectedSdgs().length === 0
                                            "
                                        >
                                            —
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td
                                    class="py-2 text-muted fw-bold border border-dark text-start"
                                    colspan="6"
                                >
                                    On Input / Output
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <td class="py-2 border border-dark" colspan="6">
                                    <ul>
                                        <li
                                            v-for="(
                                                io, index
                                            ) in getSelectedInputsOutputs()"
                                            :key="index"
                                        >
                                            {{ io }}
                                        </li>
                                        <li
                                            v-if="
                                                getSelectedInputsOutputs()
                                                    .length === 0
                                            "
                                        >
                                            —
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-2 text-muted fw-bold border border-dark text-start"
                                    colspan="6"
                                >
                                    On Production Process
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 border border-dark" colspan="6">
                                    <ul>
                                        <li
                                            v-for="(
                                                pp, index
                                            ) in getSelectedProductionProcesses()"
                                            :key="index"
                                        >
                                            {{ pp }}
                                        </li>
                                        <li
                                            v-if="
                                                getSelectedProductionProcesses()
                                                    .length === 0
                                            "
                                        >
                                            —
                                        </li>
                                    </ul>
                                </td>
                            </tr> -->
                            <!-- End Business Information Header -->

                            <!-- Participation Package Details -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 bg-transparent border-0"
                                ></td>
                            </tr>

                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Participation Package Details
                                </th>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Participation Type
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ getParticipationType() }}
                                </td>
                            </tr>

                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                ></th>
                            </tr>

                            <!-- Package Details -->
                            <tr
                                v-for="(item, index) in cart"
                                :key="'package-details-' + index"
                            >
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Package Details
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    {{ item.package_title }} -
                                    {{ item.package_sub_title }}
                                    ({{ item.space_name }})
                                </td>
                            </tr>

                            <!-- Booth Size -->
                            <tr
                                v-for="(item, index) in cart"
                                :key="'booth-size-' + index"
                            >
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Booth Size
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    {{ item.booth_size_name }}

                                    <span class="mdi mdi-window-close"></span>

                                    {{ item.qty }}
                                </td>
                            </tr>

                            <!-- Participation Fee -->
                            <tr
                                v-for="(item, index) in cart"
                                :key="'participation-fee-' + index"
                            >
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Participation Fee
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    {{ item.currency }}
                                    {{ formatNumber(item.total_participation) }}
                                </td>
                            </tr>

                            <!-- Discount -->
                            <tr
                                v-for="(item, index) in cart"
                                :key="'discount-' + index"
                            >
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Discount
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    {{ item.currency }}
                                    {{ formatNumber(item.discount) }}
                                </td>
                            </tr>

                            <!-- Total Amount -->
                            <tr
                                v-for="(item, index) in cart"
                                :key="'total-amount-' + index"
                            >
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Total Amount
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    {{ item.currency }}
                                    {{ formatNumber(item.total_amount_due) }}
                                </td>
                            </tr>

                            <!-- Discount Description -->
                            <tr
                                v-for="(item, index) in cart"
                                :key="'discount-description-' + index"
                            >
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Discount Description
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    {{
                                        item.discount_remarks
                                            ? item.discount_remarks
                                            : "—"
                                    }}
                                </td>
                            </tr>

                            <!-- Space Guidelines -->
                            <tr
                                v-for="(item, index) in cart"
                                :key="'space-guidelines-' + index"
                            >
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Space Guidelines
                                </th>

                                <td
                                    class="py-2 border border-dark"
                                    colspan="5"
                                    v-html="getBoothDetails(item.package_id)"
                                ></td>
                            </tr>

                            <!-- Spacer after packages -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 bg-transparent border-0"
                                ></td>
                            </tr>

                            <tr>
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    {{
                                        addonCart && addonCart.length
                                            ? "Total Amount"
                                            : "Estimated Total Amount Due"
                                    }}
                                </th>

                                <td class="py-2 border border-dark" colspan="5">
                                    {{ mandatory.currency }}
                                    {{ formatNumber(getTotalAmount()) }}
                                </td>
                            </tr>

                            <!-- End Participation Package Details -->

                            <!-- Additional Fees, Discounts, and Total Amount Due -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 bg-transparent bg-transparent border-0"
                                ></td>
                            </tr>

                            <tr
                                class="border-0"
                                v-if="addonCart && addonCart.length"
                            >
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Additional Fees, Discounts, and Total Amount
                                    Due
                                </th>
                            </tr>

                            <div v-if="addonCart && addonCart.length">
                                <div
                                    v-for="(addon_item, index) in addonCart"
                                    :key="index"
                                >
                                    <!-- Add-on Name  -->
                                    <tr>
                                        <th class="py-2 border border-dark">
                                            ADD-ON: {{ addon_item.qty }} x
                                            {{ addon_item.addon_name }}
                                        </th>
                                        <td
                                            class="py-2 border border-dark"
                                            colspan="5"
                                        >
                                            {{ addon_item.currency }}
                                            {{
                                                formatNumber(
                                                    addon_item.total_amount_due
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </div>
                            </div>
                            <!-- End Additional Fees, Discounts, and Total Amount Due -->
                            <!-- Add On Cart -->
                            <tr v-if="addonCart && addonCart.length">
                                <th
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Estimated Total Amount Due
                                </th>
                                <td class="py-2 border border-dark" colspan="5">
                                    {{ mandatory.currency }}
                                    {{
                                        formatNumber(
                                            getEstimatedTotalAmountDue()
                                        )
                                    }}
                                </td>
                            </tr>
                            <!-- End Add On Cart -->
                            <tr class="border-0">
                                <td
                                    colspan="6"
                                    class="py-2 bg-transparent bg-transparent border-0"
                                ></td>
                            </tr>
                            <tr class="border-0">
                                <th
                                    colspan="6"
                                    class="text-center fw-bold py-2 bg-transparent border-0"
                                >
                                    Uploaded Requirements
                                </th>
                            </tr>
                            <tr v-if="docs && docs.doc1 && docs.doc1.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Copy of registration from DTI or SEC (with
                                    complete articles of incorporation)
                                </th>

                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc1[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc1[0].url) }}
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="docs && docs.doc2 && docs.doc2.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Copy of registration from BIR (Form 2303)
                                </th>

                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc2[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc2[0].url) }}
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="docs && docs.doc3 && docs.doc3.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Copy of valid License to Operate (LTO)
                                </th>

                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc3[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc3[0].url) }}
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="docs && docs.doc4 && docs.doc4.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Copy of valid Certificate of Product
                                    Registration (CPR)
                                </th>

                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc4[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc4[0].url) }}
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="docs && docs.doc5 && docs.doc5.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Copy of valid food/ environmental
                                    certifications such as Fairtrade, FSC, Green
                                    Choice, HACCP, Halal, ISO, etc.
                                </th>

                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc5[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc5[0].url) }}
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="docs && docs.doc7 && docs.doc7.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Copy of business certification/ license
                                </th>

                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc7[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc7[0].url) }}
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="docs && docs.doc8 && docs.doc8.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Copy of valid food/environmental
                                    certification/s issued by 3rd party
                                    certification bodies (i.e. BRC, EcoCert,
                                    Green Choice, Fairtrade, FSC, HACCP, HALAL,
                                    ISO, Kosher, USDA)
                                </th>
                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc8[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc8[0].url) }}
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="docs && docs.doc6 && docs.doc6.length">
                                <th
                                    colspan="2"
                                    class="py-2 text-muted fw-bold border border-dark"
                                >
                                    Institutional brochure/catalog includes
                                    company profile, product/service photos, and
                                    map/site sketch of the company location
                                </th>

                                <td class="py-2 border border-dark" colspan="4">
                                    <a
                                        :href="
                                            convertToPublic(docs.doc6[0].url)
                                        "
                                        target="_blank"
                                        class="text-decoration-underline"
                                    >
                                        {{ convertToPublic(docs.doc6[0].url) }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "SummaryOfApplicationCard",
    props: {
        event_info: {
            type: Object,
            required: true,
        },
        company_info: {
            type: Object,
            required: true,
        },
        products: {
            type: Array,
            default: () => [],
        },
        contact_info: {
            type: Object,
            required: true,
        },
        business_info: {
            type: Object,
            required: true,
        },
        packages: {
            type: Array,
            default: () => [],
        },
        mandatory: {
            type: Object,
            required: true,
        },
        business_types: Array,
        company_sizes: Array,
        annual_sales_volumes: Array,
        organization_types: Array,
        nature_businesses: Array,
        target_buyers: Array,
        countries: Array,
        certifications: Array,
        categories: Array,
        inputs_outputs: Array,
        sdgs: Array,
        production_processes: Array,
        topics: Array,
        cart: {
            type: Array,
            default: () => [],
        },
        addOns: {
            type: Array,
            default: () => [],
        },
        addonCart: {
            type: Array,
            default: () => [],
        },
        order_info: {
            type: Object,
            required: true,
        },
        docs: {
            type: Object,
            required: true,
        },
        formatNumberFn: { type: Function, required: false },
    },
    data() {
        return {
            isDragging: false,
            startY: 0,
            startX: 0,
            scrollTop: 0,
            scrollLeft: 0,
        };
    },
    methods: {
        startDrag(e) {
            this.isDragging = true;
            this.startY = e.clientY;
            this.startX = e.clientX;
            this.scrollTop = this.$refs.scrollContainer.scrollTop;
            this.scrollLeft = this.$refs.scrollContainer.scrollLeft;
            this.$refs.scrollContainer.style.cursor = "grabbing";
            e.preventDefault(); // prevent text selection
        },
        stopDrag() {
            this.isDragging = false;
            this.$refs.scrollContainer.style.cursor = "grab";
        },
        onDrag(e) {
            if (!this.isDragging) return;
            const y = e.clientY;
            const x = e.clientX;

            const walkY = y - this.startY;
            const walkX = x - this.startX;

            this.$refs.scrollContainer.scrollTop = this.scrollTop - walkY;
            this.$refs.scrollContainer.scrollLeft = this.scrollLeft - walkX;
        },
        getCountryName(id) {
            const c = this.countries.find((ct) => ct.id === id);
            return c ? c.name : "";
        },
        getCertificationNames() {
            const selected = this.certifications
                .filter((c) => this.business_info.certification.includes(c.id))
                .map((c) => {
                    // ID 14 = Others
                    if (c.id === 14) {
                        return this.business_info.certification_others
                            ? "Others: " +
                                  this.business_info.certification_others
                            : "Others";
                    }
                    return c.name;
                });

            return selected.length ? selected.join(", ") : "—";
        },
        getIndustryRepLabel() {
            const map = {
                1: "With Export Experience",
                2: "Without Export Experience",
            };

            const val = this.business_info.industry_representation;

            return map[val] ? map[val] : "—";
        },
        getExportingCountries() {
            const list = [
                this.getCountryName(this.business_info.exporting_country_1),
                this.getCountryName(this.business_info.exporting_country_2),
                this.getCountryName(this.business_info.exporting_country_3),
            ];

            const cleaned = list.filter((n) => n !== "");

            return cleaned.length ? cleaned.join(", ") : "—";
        },
        getSelectedSubcategories() {
            // Flatten all subcategories
            const allSubcategories = this.categories.flatMap(
                (cat) => cat.sub_categories
            );

            // Filter only selected IDs
            const selected = allSubcategories
                .filter((sub) => this.business_info.category.includes(sub.id))
                .map((sub) => sub.name);

            // Return comma-separated or "—" if none
            return selected.length ? selected.join(", ") : "—";
        },
        getSelectedSdgs() {
            return this.sdgs
                .filter((sg) => this.business_info.sdg.includes(sg.id))
                .map((sg) => sg.name);
        },
        getSelectedInputsOutputs() {
            return this.inputs_outputs
                .filter((io) => this.business_info.input_ouput.includes(io.id))
                .map((io) => io.name);
        },
        getSelectedProductionProcesses() {
            const selected = this.production_processes
                .filter((pp) =>
                    this.business_info.production_process.includes(pp.id)
                )
                .map((pp) => {
                    if (pp.id === 3) {
                        return this.business_info.production_process_others
                            ? "Others: " +
                                  this.business_info.production_process_others
                            : "Others";
                    }
                    return pp.name;
                });

            return selected;
        },
        getStartUpStatus() {
            return this.business_info.start_up == 1 ? "Yes" : "No";
        },
        interestedInSSXConference() {
            return this.order_info.conference_response == 1 ? "Yes" : "No";
        },
        interestedInSponsorship() {
            return this.order_info.sponsorship_response == 1 ? "Yes" : "No";
        },
        formatNumber(value) {
            if (
                this.formatNumberFn &&
                typeof this.formatNumberFn === "function"
            ) {
                return this.formatNumberFn(value);
            }
            // fallback: emit event (no return)
            this.$emit("format-number", value);
            return value;
        },
        getBoothDetails(packageId) {
            const pkg = this.packages.find((p) => p.id === packageId);
            return pkg ? pkg.booth_details : "N/A";
        },
        getParticipationType() {
            if (this.order_info.participation_type === 1) return "Individual";
            if (this.order_info.participation_type === 2) return "Group";
            return "—";
        },
        getTotalAmount() {
            if (!this.cart || !this.cart.length) return 0;
            return this.cart.reduce(
                (sum, item) => sum + Number(item.total_amount_due || 0),
                0
            );
        },
        getEstimatedTotalAmountDue() {
            const cartTotal = this.getTotalAmount();

            const addonTotal =
                this.addonCart && this.addonCart.length
                    ? this.addonCart.reduce((sum, addon_item) => {
                          return sum + Number(addon_item.total_amount_due || 0);
                      }, 0)
                    : 0;

            return cartTotal + addonTotal;
        },
        getAddonName(addonId) {
            const addon = this.addOns.find((a) => a.id === addonId);
            return addon ? addon.name : "Unknown Add-On";
        },
        convertToPublic(url) {
            if (typeof url !== "string") return ""; // ensure it's a string
            return url.replace("public/", "storage/");
        },
    },
};
</script>
