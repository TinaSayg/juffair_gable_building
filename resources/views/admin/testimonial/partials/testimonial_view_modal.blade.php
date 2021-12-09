
<tr>
    <td>Name</td>
    <td>{{ isset($testimonial->name) ? $testimonial->name: '' }}</td>
</tr>
<tr>
    <td>Review</td>
    <td>{{ isset($testimonial->review) ? $testimonial->review: '' }}</td>
</tr>

<tr>
    <td>Image</td>
    <td><a href="{{ url('public/admin/assets/img/testimonial') }}/{{ isset($testimonial->image)? $testimonial->image : '' }}" target="blank">view</a></td>
</tr>